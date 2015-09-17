<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

class ColourpickerFieldType extends AbstractFieldType
{
    protected $name = 'Colourpicker';

    protected $key = 'colourpicker';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
    ];
}
