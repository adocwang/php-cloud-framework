<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 29/11/2017
 * Time: 11:10
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('APP_ROOT', ROOT . DS . "examples");
require_once ROOT . DS . 'vendor' . DS . 'autoload.php';
include_once APP_ROOT . DS . 'provider.php';