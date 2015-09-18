<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

class SelectFieldType extends AbstractFieldType
{
    protected $name = 'Select';

    protected $key = 'select';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
    ];
}
