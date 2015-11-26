<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
//use Escape\Argon\EntityManagement\FieldValues\ComboFieldValue;

class ComboFieldType extends AbstractFieldType
{
    protected $name = 'Combo';

    protected $key = 'combo';

    protected $group;

    protected $properties = [
        'multiple' => [
            'label' => 'Multiple',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allows multiple values.",
        ],
    ];

    public function getValue(FieldData $data=null)
    {
        return @$data->value;
//        return new TextFieldValue($data); // commented out since multiple field property will end up here with array... and __toString obviously will not like that.
    }
}
