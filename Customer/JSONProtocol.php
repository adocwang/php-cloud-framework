<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 01/12/2017
 * Time: 14:35
 */

namespace PhpCloud\Framework\Customer;


class JSONProtocol
{

    /**
     * 将数据打包成Rpc协议数据
     * @param mixed $data
     * @return string
     */
    public static function encode($data)
    {
        return json_encode($data)."\n";
    }

    /**
     * 解析Rpc协议数据
     * @param string $bin_data
     * @return mixed
     */
    public static function decode($bin_data)
    {
        return json_decode(trim($bin_data), true);
    }
}