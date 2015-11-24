<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;

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

    public function getValue(FieldData $data=null)
    {
        throw new \Exception('Not implemented');
    }
}
