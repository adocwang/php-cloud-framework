<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 29/11/2017
 * Time: 11:48
 */

namespace PhpCloud\Framework\Provider;

use PhpCloud\Framework\Provider\Exceptions\ProviderExecutorException;
use PhpCloud\Framework\Provider\Router\RouterException;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;


class WorkerJsonProvider extends ProviderAbstract
{
    private $worker;

    public function __construct(Configure $config)
    {
        $config->set('protocol', 'text');
        if ($config->get('workers') === null) {
            $config->set('workers', 2);
        }
        parent::__construct($config);
    }

    public function bootUp()
    {
        if (!$this->checkEnv()) {
            throw new \Exception('env not ready');
        }
        $listenUri = $this->config->get('protocol') . '://' . $this->config->get('listen') . ':' . $this->config->get('port');
        Worker::$daemonize = $this->config->get('daemonize');
        $this->worker = new Worker($listenUri);
        $this->worker->count = $this->config->get('workers');
        $this->worker->onMessage = array($this, 'onMessage');
        $this->worker->onClose = function ($connection) {
            $this->console->debug(['connection closed', $connection->id]);
        };
        Worker::runAll();
    }

    public function onMessage(TcpConnection $connection, $data)
    {
//        print_r($data);
        $this->console->debug(['onMessage id:', $connection->id, 'data:', $data]);
        $data = json_decode($data, true);
        $path = $data['path'];
        if (false !== $pos = strpos($path, '?')) {
            $path = substr($path, 0, $pos);
        }
        $input = ProviderInput::fromArray($data);
        $outputResult = 0;
        try {
            $result = $this->execute($input);
            /**
             * @var $output ProviderOutput
             */
            $outputResult = ProviderOutput::createResult(Constants::CODE_OK, $result);
            $this->console->info([$path, Constants::CODE_OK]);
        } catch (\Exception $e) {
            if ($e instanceof RouterException) {
                $outputResult = ProviderOutput::createError(RouterException::NOT_FOUND_CODE, $e->getMessage());
            } elseif ($e instanceof ProviderExecutorException) {
                $outputResult = ProviderOutput::createError($e->getCode(), $e->getMessage());
            }
            $this->console->error([$path, $outputResult]);
        }
        $connection->send($outputResult);
        $this->console->debug(['sendResult id:' . $connection->id . ' result:', $outputResult]);
    }

    private function checkEnv()
    {
        $version_ok = $pcntl_loaded = $posix_loaded = false;
        if (version_compare(phpversion(), "5.5.0", ">=")) {
            $this->console->debug('version ok');
            $version_ok = true;
        }
        if (in_array("pcntl", get_loaded_extensions())) {
            $this->console->debug('pcntl ok');
            $pcntl_loaded = true;
        }
        if (in_array("posix", get_loaded_extensions())) {
            $this->console->debug('posix ok');
            $posix_loaded = true;
        }
        if ($version_ok && $pcntl_loaded && $posix_loaded) {
            return true;
        }
        return false;
    }

    public function shutDown()
    {
    }
}