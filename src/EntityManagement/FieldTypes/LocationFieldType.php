<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

class LocationFieldType extends AbstractFieldType
{
    protected $name = 'Location';

    protected $key = 'location';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
    ];
}
