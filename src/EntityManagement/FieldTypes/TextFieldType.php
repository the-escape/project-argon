<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\TextFieldValue;

class TextFieldType extends AbstractFieldType
{
    protected $name = 'Text';

    protected $key = 'text';

    protected $group;

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
        'multiple' => [
            'label' => 'Multiple',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allow multiple instances of a field (cloning).",
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
        ],
        'url' => [
            'label' => 'Validate as url?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
        'integer' => [
            'label' => 'Validate as integer?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
        'float' => [
            'label' => 'Validate as floating point number?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
        'email' => [
            'label' => 'Validate as email?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
        'phone' => [
            'label' => 'Validate as phone number?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
    ];

    public function getValue(FieldData $data=null)
    {
        return @$data->value;
//        return new TextFieldValue($data); // commented out since multiple field property will end up here with array... and __toString obviously will not like that.
    }
}
