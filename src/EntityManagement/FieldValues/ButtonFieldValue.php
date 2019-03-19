<?php

namespace Escape\Argon\EntityManagement\FieldValues;

class ButtonFieldValue extends AbstractFieldValue implements \IteratorAggregate
{
    public function __construct($data = null)
    {
        // make data consistently object
        if ($data)
        {
            if (isJson($data))
            {
                $data = json_decode($data);
            }

            if (is_object($data))
            {
                $data = (array)$data;
            }

            foreach ($data as $k => &$v)
            {
                if (is_array($v))
                {
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

    public function toJson($options = 0)
    {
        $values = $this->compress();
        return json_encode($values, $options);
    }

    public function compress()
    {
        $values = [];
        $data = $this->toArray();
        foreach ($data as $value)
        {
            $values[] = (array) $value;
        }

        return $values;
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


    public function getLabel()
    {
        if (!empty($this->data)) {
            foreach ($this->data as $data) {
                return isset($data->label) ? $data->label : null;
            }
        }

        return null;
    }


    public function getUrl()
    {
        if (!empty($this->data)) {
            foreach ($this->data as $data) {
                return isset($data->url) ? $data->url : null;
            }
        }

        return null;
    }


    public function getClass()
    {
        if (!empty($this->data)) {
            foreach ($this->data as $data) {
                return isset($data->class) ? $data->class : null;
            }
        }

        return null;
    }


    public function getId()
    {
        if (!empty($this->data)) {
            foreach ($this->data as $data) {
                return isset($data->id) ? $data->id : null;
            }
        }

        return null;
    }


    public function getTarget()
    {
        if (!empty($this->data)) {
            foreach ($this->data as $data) {
                return isset($data->target) ? $data->target : null;
            }
        }

        return null;
    }

}
