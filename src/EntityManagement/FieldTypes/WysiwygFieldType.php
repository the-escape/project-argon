<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

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
}
