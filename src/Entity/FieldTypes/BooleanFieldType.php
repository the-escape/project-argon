<?php

namespace Escape\Argon\Entity\FieldTypes;

use Escape\Argon\Entity\Eloquent\FieldData;
use Escape\Argon\Entity\FieldValues\BooleanFieldValue;

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

    public function parseData(FieldData $data = null)
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

        return view('argon::fields.type.boolean', $data)->render();
    }
}
