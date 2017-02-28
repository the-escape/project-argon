<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldTypes\AbstractFieldType;

abstract class AbstractFieldValue
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function __toString()
    {
        if (is_array($this->data)) {
            return implode(PHP_EOL, $this->data);
        } elseif ($this->data) {
            return $this->data;
        } else {
            return "";
        }
    }

    public function getData()
    {
        return $this->data;
    }


    public function isEmpty()
    {
        if (is_array($this->data)) {
            $count = count($this->data);

            if ($count === 0) {
                reset($this->data);
                return true;
            }

            $c = 0;
            foreach ($this->data as $k => $v) {
                if ($v == '') {
                    $c++;
                }
            }

            if ($count == $c) {
                reset($this->data);
                return true;
            }

            reset($this->data);
            return false;
        }

        if (($this->data === '') || ($this->data === null)) {
            return true;
        }

        return false;
    }


    /**
     * Field may have been saved initialy as multiple.
     * If later it changes to single, reduce saved values accordingly.
     * @return array|null
     */
    public function first()
    {
        if (is_array($this->data) && (count($this->data) > 1)) {
            return new static(array_slice($this->data, 0, 1));
        }

        return $this;
    }
}
