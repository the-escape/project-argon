<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;

class VideoFieldType extends AbstractFieldType
{
    protected $name = 'Video';

    protected $key = 'video';

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

    public function getValue(FieldData $data = null)
    {
        throw new \Exception('Not implemented');
    }
}
