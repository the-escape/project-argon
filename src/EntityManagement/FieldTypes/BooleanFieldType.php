<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;

class BooleanFieldType extends AbstractFieldType
{
    protected $name = 'Boolean';

    protected $key = 'boolean';

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
