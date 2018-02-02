<?php

/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 30/11/2017
 * Time: 16:38
 */
namespace PhpCloud\Framework\Customer;

abstract class CustomerAbstract
{
    protected $customerRequest;
    protected $serverAddress;
    protected $debug = false;

    public function __construct($serverAddress, $debug = false)
    {
        $this->serverAddress = $serverAddress;
        $this->debug = $debug;
        return $this;
    }

    public abstract function call($path, $data);

}