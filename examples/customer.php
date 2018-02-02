<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 30/11/2017
 * Time: 17:40
 */
include dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use PhpCloud\Framework\Customer\SwooleJsonCustomer;

$customer = new SwooleJsonCustomer('127.0.0.1:8090', false);
echo $customer->call('/hello', ['name' => 'world']);