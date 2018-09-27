<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\MenuFieldValue;

class MenuFieldType extends AbstractFieldType
{
    protected $name = 'Menu';

    protected $key = 'menu';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'multiple' => [
            'label' => 'Multiple',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allow multiple instances of a field (cloning).",
        ],
    ];

    public function parseData($data = null)
    {
        if ($data instanceof FieldData)
        {
            return new MenuFieldValue($data->value);
        }

        return new MenuFieldValue($data);
    }

    public function getOptions()
    {
        return menuCache();
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
                $value = new MenuFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new MenuFieldValue();
        }

        $data = array_merge(
            ['hash' => ''],
            $data,
            ['field' => $this, 'value' => $value, 'isCloning' => $this->isCloning]
        );
        return view('argon::fields.type.menu', $data)->render();
    }
}
