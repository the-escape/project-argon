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
        'multiple' => [
            'label' => 'Multiple select dropdown',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allow selecting multiple items through one dropdown.",
        ],
        'multiple_instances' => [
            'label' => 'Standard select field - multiple instances.',
            'type' => 'boolean',
            'default' => false,
            'help' => "Single selection multiple times.",
        ],
        'items' => [
            'label' => 'Items',
            'type' => 'items',
            'default' => '',
            'help' => "",
        ],
    ];

    public function parseData($data = null)
    {
        if ($data instanceof FieldData)
        {
            return new ItemFieldValue($data->value);
        }

        return new ItemFieldValue($data);
    }

    public function getOptions()
    {
        $contentTypeIds = $this->getSetting('items');
        if (!is_array($contentTypeIds)) {
            $contentTypeIds = [$contentTypeIds];
        }
        /** @var EntityRepository $entityRepository */
        $entityRepository = app()->make(EntityRepository::class);
        $options = $entityRepository->findWhereIn('entity_type_id', $contentTypeIds);
        return $options;
    }

    public function getFormFieldName($hash)
    {
        return parent::getFormFieldName($hash) . '[]';
    }

    public function render($value = null, $data = [])
    {
        if (!$this->isInCombo()) {
            $submitted = old('fields.' . $this->getId());
            if ($submitted !== null) {
                $value = new ItemFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new ItemFieldValue();
        }

        $data = array_merge(
            ['hash' => ''],
            $data,
            ['field' => $this, 'value' => $value, 'isCloning' => $this->isCloning]
        );
        return view('argon::fields.type.item', $data)->render();
    }
}
