<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;

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
        'multiple' => [
            'label' => 'Multiple',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allow multiple instances of a field (cloning).",
        ],
        'options' => [
            'label' => 'Option',
            'type' => 'options',
            'default' => '',
            'help' => "Enter the option label",
        ],
    ];


    public function getValue(FieldData $data=null)
    {
        return @$data->value;
//        return new SelectFieldValue($data); // commented out since multiple field property will end up here with array... and __toString obviously will not like that.
    }
}
