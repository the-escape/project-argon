<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\BooleanFieldValue;

class BooleanFieldType extends AbstractFieldType
{
    protected $name = 'Boolean';

    protected $key = 'boolean';

    protected $properties = [
        'initial_value' => [
            'label' => 'Select initial value',
            'type' => 'select',
            'options' => [
                '0' => 'FALSE',
                '1' => 'TRUE',
            ],
            'default' => '0',
            'help' => null,
        ]
    ];

    public function parseData($data = null)
    {
        if ($data instanceof FieldData)
        {
            return new BooleanFieldValue($data->value);
        }

        return new BooleanFieldValue($data);
    }

    public function getInitialValue()
    {
        return $this->getSetting('initial_value');
    }

    public function render($value = null, $data = [])
    {
        if (!$this->isInCombo()) {
            $submitted = old('fields.' . $this->getId());
            if ($submitted !== null) {
                $value = new BooleanFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new BooleanFieldValue($this->getInitialValue());
        }

        $data = array_merge(
            ['hash' => ''],
            $data,
            ['field' => $this, 'value' => $value, 'isCloning' => $this->isCloning]
        );
        dd($data);
        return view('argon::fields.type.boolean', $data)->render();
    }
}
