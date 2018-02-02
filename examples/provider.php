<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 29/11/2017
 * Time: 11:16
 */
include APP_ROOT . DS . 'controller' . DS . 'TestController.php';
use PhpCloud\Framework\Provider\SwooleHttpJsonProvider;
use PhpCloud\Framework\Provider\Configure;

$configure = new Configure([
    'debug' => true,
    'daemonize' => false
]);
$provider = new SwooleHttpJsonProvider($configure);
$provider->addRoute('/', ['TestController', 'test']);
$provider->addRoute('/hello', ['TestController', 'hello']);
$provider->addRoute('/addDomain', ['TestController', 'addDomain']);
$provider->bootUp();