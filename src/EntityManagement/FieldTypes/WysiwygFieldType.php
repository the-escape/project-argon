<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;

class WysiwygFieldType extends AbstractFieldType
{
    protected $name = 'Wysiwyg';

    protected $key = 'wysiwyg';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
    ];

    public function getValue(FieldData $data)
    {
        throw new \Exception('Not implemented');
    }
}
