<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 30/11/2017
 * Time: 18:05
 */

namespace PhpCloud\Framework\Customer;


use PhpCloud\Framework\Customer\Exceptions\CustomerRequestException;

class StreamJsonCustomer extends CustomerAbstract
{
    /**
     * 发送数据和接收数据的超时时间  单位S
     * @var integer
     */
    const TIME_OUT = 3;

    /**
     * 到服务端的socket连接
     * @var resource
     */
    protected $connection = null;

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
        $bin_data = JSONProtocol::encode(array(
            'path' => $path,
            'data' => $data,
        ));
//        $bin_data .= "\n";
        if (fwrite($this->connection, $bin_data) !== strlen($bin_data)) {
            throw new CustomerRequestException('Can not send data');
        }
        if ($this->debug) {
            echo "customer send:" . $bin_data;
        }
        return true;
    }

    /**
     * 从服务端接收数据
     * @throws CustomerRequestException
     */
    public function receiveData()
    {
        $resultJSON = fgets($this->connection);
        $this->closeConnection();
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
        $this->connection = stream_socket_client('tcp://' . $this->serverAddress, $err_no, $err_msg);
        if (!$this->connection) {
            throw new \Exception("can not connect to $this->serverAddress , $err_no:$err_msg");
        }
        stream_set_blocking($this->connection, true);
        stream_set_timeout($this->connection, self::TIME_OUT);
    }

    /**
     * 关闭到服务端的连接
     * @return void
     */
    protected function closeConnection()
    {
        fclose($this->connection);
        $this->connection = null;
    }

    public function __destruct()
    {
        if (!empty($this->connection)) {
            $this->closeConnection();
        }
    }
}