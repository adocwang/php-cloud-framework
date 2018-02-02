<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 30/11/2017
 * Time: 18:05
 */

namespace PhpCloud\Framework\Customer;


use PhpCloud\Framework\Customer\Exceptions\CustomerRequestException;
use Swoole\Client;

class SwooleJsonCustomer extends CustomerAbstract
{
    /**
     * 发送数据和接收数据的超时时间  单位S
     * @var integer
     */
    const TIME_OUT = 3;

    protected $client = null;

    /**
     * 同步调用
     * @param $path
     * @param $data
     * @return mixed
     */
    public function call($path, $data)
    {

        $this->sendData($path, $data);
        $res = $this->receiveData();
        if ($this->debug) {
            echo 'get remote data:' . $res;
        }
        return $res;
    }

    /**
     * 发送数据给服务端
     * @param string $path
     * @param array $data
     * @return bool
     * @throws CustomerRequestException
     */
    public function sendData($path, $data)
    {
        $this->openConnection();
        $bin_data = json_encode([
            'path' => $path,
            'data' => $data,
        ]);
        $this->client->send($bin_data);
        return true;
    }

    /**
     * 从服务端接收数据
     * @throws CustomerRequestException
     */
    public function receiveData()
    {
        $resultJSON = $this->client->recv();
        if (!$resultJSON) {
            return '';
        }
        $result = JSONProtocol::decode($resultJSON);
        if ($result['code'] === 200) {
            return $result['data'];
        } else {
            throw new CustomerRequestException($resultJSON, 500);
        }
    }

    /**
     * 打开到服务端的连接
     * @throws \Exception
     */
    protected function openConnection()
    {
        $address = explode(":", $this->serverAddress);
        $this->client = new Client(SWOOLE_SOCK_TCP);
        $this->client->connect($address[0], $address[1], self::TIME_OUT);
    }

    /**
     * 关闭到服务端的连接
     * @return void
     */
    protected function closeConnection()
    {
        fclose($this->client);
        $this->client->close();
        $this->client = null;
    }

    public function __destruct()
    {
        if (!empty($this->connection)) {
            $this->closeConnection();
        }
    }
}