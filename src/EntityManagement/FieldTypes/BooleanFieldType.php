<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\BooleanFieldValue;

class BooleanFieldType extends AbstractFieldType
{
    protected $name = 'Boolean';

    protected $key = 'boolean';

    protected $properties = [
    ];

    public function parseData(FieldData $data)
    {
        return new BooleanFieldValue($data->value);
    }
}
