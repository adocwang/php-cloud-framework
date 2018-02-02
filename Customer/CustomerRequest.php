<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 01/12/2017
 * Time: 10:59
 */

namespace PhpCloud\Framework\Customer;


use PhpCloud\Framework\Customer\Exceptions\CustomerRequestException;

class CustomerRequest
{
    private $path;
    private $data = "";

    public function __construct($path, $data = "")
    {
        if (is_array($path)) {
            if (!isset($path['path'])) {
                throw new CustomerRequestException('no path', 500);
            }
            $this->path = $path['path'];
            if (isset($path['data'])) {
                $this->data = $path['data'];
            }
        } else {
            $this->path = $path;
            $this->data = $data;
        }
    }

    public function toArray()
    {
        return [
            'path' => $this->path,
            'data' => $this->data
        ];
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

}