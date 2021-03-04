<?php

namespace App\Payment\Common;

use ArrayAccess;

abstract class ArrayAccessableResource implements ArrayAccess
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function offsetExists($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function offsetGet($key)
    {
        return $this->data[$key];
    }

    public function offsetSet($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }
}