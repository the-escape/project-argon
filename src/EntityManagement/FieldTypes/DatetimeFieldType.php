<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;

class DatetimeFieldType extends AbstractFieldType
{
    protected $name = 'Datetime';

    protected $key = 'datetime';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
    ];

    public function getValue(FieldData $data)
    {
        throw new \Exception('Not implemented');
    }
}
