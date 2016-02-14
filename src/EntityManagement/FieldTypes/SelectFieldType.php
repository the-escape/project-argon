<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\SelectFieldValue;

class SelectFieldType extends AbstractFieldType
{
    protected $name = 'Select';

    protected $key = 'select';

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
        'options' => [
            'label' => 'Option',
            'type' => 'options',
            'default' => [],
            'help' => "Enter the option label",
        ],
    ];

    public function getOptions()
    {
        return (array)$this->getSetting('options');
    }

    public function getFormFieldName($hash)
    {
        return parent::getFormFieldName($hash) . '[]';
    }

    public function parseData(FieldData $data)
    {
        return new SelectFieldValue($data->value);
    }

    public function render($value = null, $data = [])
    {
        if (!$this->isInCombo()) {
            $submitted = old('fields.' . $this->getId());
            if ($submitted !== null) {
                $value = new SelectFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new SelectFieldValue();
        }

        $data = array_merge(
            ['hash' => ''],
            $data,
            ['field' => $this, 'value' => $value, 'isCloning' => $this->isCloning]
        );

        return view('argon::fields.type.select', $data)->render();
    }
}
