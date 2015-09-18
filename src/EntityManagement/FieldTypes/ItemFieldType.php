<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

class ItemFieldType extends AbstractFieldType
{
    protected $name = 'Item';

    protected $key = 'item';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
    ];
}
