<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 01/12/2017
 * Time: 10:54
 */

namespace PhpCloud\Framework\Customer;


class CustomerResult
{
    private $code;
    private $message;
    private $data;
    private $request;

    public function __construct($code, $message, $data)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
}