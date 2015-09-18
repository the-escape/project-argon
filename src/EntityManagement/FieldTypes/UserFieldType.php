<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

class UserFieldType extends AbstractFieldType
{
    protected $name = 'User';

    protected $key = 'user';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
    ];
}
