<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use RuntimeException;

class CacheMediaItemValue
{
    protected $id;
    protected $url;
    protected $alt;

    public function __construct(array $values=[])
    {
        foreach ($values as $key => $value)
        {
            if (!property_exists($this, $key))
            {
                continue;
            }

            $this->$key = $value;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getAlt()
    {
        return $this->alt;
    }

    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    public function __call($name, $arguments)
    {
        $debug = config('app.debug');

        if ($debug === true)
        {
            throw new RuntimeException("Class '".__CLASS__. "' doesn't have a method '$name'.");
        }

        // Perhaps better to silence the errors here...
        return "";
    }
}
