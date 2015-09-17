<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

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
}
