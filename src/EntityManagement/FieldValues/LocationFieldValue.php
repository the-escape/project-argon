<?php

namespace Escape\Argon\EntityManagement\FieldValues;

class LocationFieldValue extends AbstractFieldValue implements \IteratorAggregate
{
    public function __construct($data = null)
    {
        // make data consistently object
        if ($data) {
            if (is_object($data)) {
                $data = (array)$data;
            }
            foreach ($data as $k => &$v) {
                if (is_array($v)) {
                    $v = (object)$v;
                }
            }
        }

        $this->data = $data;
    }

    public function __toString()
    {
        if ($this->isEmpty())
        {
            return "";
        }

        return json_encode($this->data);
    }


    public function isEmpty()
    {
        if (is_array($this->data))
        {
            foreach ($this->data as $key => $value)
            {
                if (is_object($value))
                {
                    foreach ($value as $k => $v)
                    {
                        if ($v != "" && $v !== null)
                        {
                            return false;
                        }
                    }
                }    
            }
            return true;
        }

        if (($this->data === '') || ($this->data === null)) {
            return true;
        }

        return false;
    }

    public function getIterator()
    {
        if ($this->data == null) {
            $data = [''];
        } else {
            $data = $this->data;
        }

        if (!is_array($data)) {
            $data = [$data];
        }

        return new \ArrayIterator($data);
    }


    public function getLatitude()
    {
        if (!empty($this->data)) {
            foreach ($this->data as $data) {
                return $data->latitude;
            }
        }

        return null;
    }


    public function getLongitude()
    {
        if (!empty($this->data)) {
            foreach ($this->data as $data) {
                return $data->longitude;
            }
        }

        return null;
    }

}