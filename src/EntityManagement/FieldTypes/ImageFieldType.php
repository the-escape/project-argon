<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

class ImageFieldType extends AbstractFieldType
{
    protected $name = 'Image';

    protected $key = 'image';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false
        ],
        'multiple' => [
            'label' => 'Multiple?',
            'type' => 'boolean',
            'default' => false
        ],
        'width' => [
            'label' => 'Width',
            'type' => 'integer',
            'default' => null,
        ],
        'height' => [
            'label' => 'Height',
            'type' => 'integer',
            'default' => null,
        ],
        'help' => [
            'label' => 'HelpText',
            'type' => 'text',
            'default' => null,
        ],
    ];
}
