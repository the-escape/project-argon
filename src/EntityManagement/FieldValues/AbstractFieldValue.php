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
        if ($this->data !== null) {
            return $this->data;
        } else {
            return '';
        }
    }
}
