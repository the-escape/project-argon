<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\ItemFieldValue;

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

    public function parseData(FieldData $data)
    {
        return new ItemFieldValue($data->value);
    }

    public function getOptions()
    {
        $contentTypeId = $this->getSetting('items');
        $entityRepository = app()->make(EntityRepository::class);
        $options = $entityRepository->findByField('entity_type_id', $contentTypeId);
        return $options;
    }
}
