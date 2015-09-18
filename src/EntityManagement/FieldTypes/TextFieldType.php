<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\TextFieldValue;

class TextFieldType extends AbstractFieldType
{
    protected $name = 'Text';

    protected $key = 'text';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'multiline' => [
            'label' => 'Multiline',
            'type' => 'boolean',
            'default' => false,
            'help' => 'Display field as textarea',
        ],
        'minlength' => [
            'label' => 'Minimum Length',
            'type' => 'integer',
            'default' => null,
            'help' => null,
        ],
        'maxlength' => [
            'label' => 'Maximum Length',
            'type' => 'integer',
            'default' => null,
            'help' => null,
        ]
    ];

    public function getValue(FieldData $data)
    {
        return new TextFieldValue($data);
    }
}
