<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;

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

    public function getValue(FieldData $data)
    {
        throw new \Exception('Not implemented');
    }
}
