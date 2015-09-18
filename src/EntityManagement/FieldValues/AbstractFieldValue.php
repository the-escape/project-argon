<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldTypes\AbstractFieldType;

abstract class AbstractFieldValue
{
    protected $data;

    public function __construct(FieldData $data)
    {
        $this->data = $data;
    }

    public function __toString()
    {
        return $this->data->value;
    }
}
