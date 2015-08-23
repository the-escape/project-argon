<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

class TextFieldType extends AbstractFieldType
{
    protected $name = 'Text';

    protected $key = 'text';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false
        ],
        'minlength' => [
            'label' => 'Minimum Length',
            'type' => 'integer',
            'default' => null,
        ],
        'maxlength' => [
            'label' => 'Maximum Length',
            'type' => 'integer',
            'default' => null,
        ]
    ];
}
