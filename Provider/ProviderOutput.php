<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 29/11/2017
 * Time: 15:23
 */

namespace PhpCloud\Framework\Provider;


class ProviderOutput
{
    private $code = Constants::CODE_OK;
    private $message = "OK";
    private $data = null;

    public function __construct($code, $message = "OK", $data = null)
    {
        $this->code = (int)$code;
        $this->message = $message;
        $this->data = $data;
    }

    public static function createError($code, $error)
    {
        $output = new ProviderOutput($code, $error);
        return $output->toJSON();
    }

    public static function createResult($code, $data)
    {
        $output = new ProviderOutput($code, "OK", $data);
        return $output->toJSON();
    }

    public function toJSON()
    {
        $result = ['code' => $this->code];
        if (!empty($this->message)) {
            $result['message'] = $this->message;
        }
        if (!empty($this->data)) {
            $result['data'] = $this->data;
        }
        return json_encode($result);
    }
}