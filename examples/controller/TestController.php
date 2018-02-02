<?php
use PhpCloud\Framework\Customer\SwooleJsonCustomer;
use PhpCloud\Framework\Provider\ProviderInput;

/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 30/11/2017
 * Time: 09:57
 */
class TestController
{
    private $input;

    public function __construct(ProviderInput $input)
    {
        $this->input = $input;
    }

    public function test()
    {
        return ['data' => $this->input];
    }

    public function hello()
    {
        $data = $this->input->getData();
        $name = 'null';
        if (!empty($data['name'])) {
            $name = $data['name'];
        }
        $customer = new SwooleJsonCustomer('127.0.0.1:8090');
        $name = $customer->call('/addDomain', ['name' => $name]);
        return 'hello ' . $name;
    }

    public function addDomain()
    {
        $data = $this->input->getData();
        $name = 'null';
        if (!empty($data['name'])) {
            $name = $data['name'];
        }
        return $name . '@chekuangdashi.com';
    }
}