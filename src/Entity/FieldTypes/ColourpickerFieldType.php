<?php

namespace Escape\Argon\Entity\FieldTypes;

use Escape\Argon\Entity\Eloquent\FieldData;

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

    public function getValue(FieldData $data = null)
    {
        throw new \Exception('Not implemented');
    }
}
