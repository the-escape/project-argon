<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;

class ImageFieldType extends AbstractFieldType
{
    protected $name = 'Image';

    protected $key = 'image';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'multiple' => [
            'label' => 'Multiple?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'width' => [
            'label' => 'Width',
            'type' => 'integer',
            'default' => null,
            'help' => null,
        ],
        'height' => [
            'label' => 'Height',
            'type' => 'integer',
            'default' => null,
            'help' => null,
        ],
        'help' => [
            'label' => 'HelpText',
            'type' => 'text',
            'default' => null,
            'help' => null,
        ],
    ];

    public function getValue(FieldData $data)
    {
        throw new Exception('Not implemented');
    }
}
