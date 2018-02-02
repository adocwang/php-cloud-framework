<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 29/11/2017
 * Time: 11:14
 */


namespace PhpCloud\Framework\Provider;

use PhpCloud\Framework\Provider\Router\ProviderRouter;
use FastRoute;
use PhpCloud\Framework\Provider\Router\RouterException;
use PhpCloud\Framework\Provider\Exceptions\ProviderExecutorException;

abstract class ProviderAbstract
{
    protected $config;
    /**
     * @var $router ProviderRouter
     */
    protected $router;

    /**
     * @var $console ProviderConsole
     */
    protected $console;

    public function __construct(Configure $config)
    {
        $this->config = $config;
        $this->router = new ProviderRouter();
        $this->console = new ProviderConsole($this->config->get('debug'));
    }

    public abstract function bootUp();

    public abstract function shutDown();

    public function execute(ProviderInput $input)
    {
        $route = $this->router->dispatch('CALL', $input->getPath());
        switch ($route[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                throw new RouterException('Route Not Found:' . $input->getPath(), RouterException::NOT_FOUND_CODE);

            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                throw new RouterException('Forbidden:' . $input->getPath(), RouterException::FORBIDDEN_CODE);

            case FastRoute\Dispatcher::FOUND:
                try {
                    $executor = new ProviderExecutor();
                    $executor->setInput($input);
                    return $executor->run($route[1], $route[1]);
                } catch (\Exception $e) {
                    throw new ProviderExecutorException($e->getMessage(), 500);
                }
        }
    }

    public function addRoute($route, $handler)
    {
        $this->router->addRoute(['CALL'], $route, $handler);
    }

    public function __destruct()
    {
        $this->shutDown();
    }

    /**
     * @return ProviderRouter
     */
    public function getRouter()
    {
        return $this->router;
    }
}