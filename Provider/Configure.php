<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 29/11/2017
 * Time: 11:20
 */

namespace PhpCloud\Framework\Provider;


class Configure
{
    public $configs = [
        'protocol' => 'http',
        'listen' => '0.0.0.0',
        'port' => 8090,
        'debug' => false,
    ];

    public function __construct(array $configs = [])
    {
        $this->set($configs);
    }

    public function set($config, $value = null)
    {
        if (is_string($config)) {
            $this->configs[$config] = $value;
        } elseif (is_array($config)) {
            foreach ($config as $key => $value) {
                $this->configs[$key] = $value;
            }
        }
    }

    public function get($key = null)
    {
        if ($key === null) {
            return $this->configs;
        } else {
            if (!isset($this->configs[$key])) {
                return null;
            }
            return $this->configs[$key];
        }
    }
}