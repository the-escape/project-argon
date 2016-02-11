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
        'items' => [
            'label' => 'Items',
            'type' => 'items',
            'default' => '',
            'help' => "",
        ],
    ];

    public function getValue(FieldData $data=null)
    {
        throw new \Exception('Not implemented');
    }

    public function parseData(FieldData $data)
    {
        return new ItemFieldvalue($data->value);
    }

    public function getOptions()
    {
        return (array)$this->getSetting('options');
    }
}
