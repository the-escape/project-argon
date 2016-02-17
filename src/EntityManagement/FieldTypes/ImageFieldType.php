<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\ImageFieldValue;

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

    public function parseData(FieldData $data)
    {
        return new ImageFieldValue($data->value);
    }

    public function render($value = null, $data = [])
    {
        if ($value === null) {
            $value = new ImageFieldValue();
        }

        $data = array_merge(
            ['hash' => ''],
            $data,
            ['field' => $this, 'value' => $value, 'isCloning' => $this->isCloning]
        );

        return view('argon::fields.type.image', $data)->render();
    }
}
