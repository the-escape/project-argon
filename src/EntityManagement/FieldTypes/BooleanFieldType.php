<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\BooleanFieldValue;

class BooleanFieldType extends AbstractFieldType
{
    protected $name = 'Boolean';

    protected $key = 'boolean';

    protected $properties = [
        'initial_value' => [
            'label' => 'Select initial value',
            'type' => 'select',
            'options' => [
                '0' => 'FALSE',
                '1' => 'TRUE',
            ],
            'default' => '0',
            'help' => null,
        ]
    ];

    public function parseData(FieldData $data)
    {
        return new BooleanFieldValue($data->value);
    }
}
