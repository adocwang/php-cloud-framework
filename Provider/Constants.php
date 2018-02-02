<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 29/11/2017
 * Time: 15:43
 */

namespace PhpCloud\Framework\Provider;


class Constants
{
    const METHOD_GET = "GET";
    const METHOD_POST = "POST";
    const METHOD_PUT = "PUT";
    const METHOD_DELETE = "DELETE";

    const CODE_OK = 200;
    const CODE_METHOD_NOT_FOUND = 405;
    const CODE_URI_NOT_FOUND = 404;
    const CODE_SERVER = 500;
    const CODE_FORBIDDEN = 503;
}