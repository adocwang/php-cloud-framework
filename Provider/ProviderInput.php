<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 29/11/2017
 * Time: 15:23
 */

namespace PhpCloud\Framework\Provider;


class ProviderInput
{
    private $path = "/";
    private $data = [];

    public function __construct($path = "/", $data = [])
    {
        $this->path = $path;
        $this->dara = $data;
    }

    public static function fromArray($params)
    {
        $input = new self($path = "", $data = []);
        if (!empty($params['path'])) {
            $input->path = $params['path'];
        }
        if (!empty($params['data'])) {
            $input->data = $params['data'];
        }
        return $input;
    }

    public function toJson()
    {
        return [
            'path' => $this->path,
            'data' => $this->data
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}