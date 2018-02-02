<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 30/11/2017
 * Time: 14:43
 */

namespace PhpCloud\Framework\Provider\Router;


class RouterException extends \Exception
{
    const NOT_FOUND_CODE = 404;
    const FORBIDDEN_CODE = 503;
}