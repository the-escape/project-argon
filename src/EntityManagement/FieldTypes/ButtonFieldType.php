<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\ButtonFieldValue;


class ButtonFieldType extends AbstractFieldType
{
    protected $name = 'Button';

    protected $key = 'button';

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
            return new ButtonFieldValue($data->value);
        }

        return new ButtonFieldValue($data);
    }

    public function getFormFieldName($hash)
    {
        if ($this->isInCombo()) {
            return "combo[{$this->getParentId()}][$hash][fields][{$this->getId()}]";
        } else {
            return "fields[{$this->getId()}][$hash]";
        }
    }

    public function render($value = null, $data = [])
    {
        if (!$this->isInCombo()) {
            $submitted = old('fields.' . $this->getId());
            if ($submitted !== null) {
                $value = new ButtonFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new ButtonFieldValue();
        }

        // if field is not multiple, get first key->value pair of value array
        if (!$this->allowMultiple() && !$value->isEmpty())
        {
            $value = $value->first();
        }

        $data = array_merge(
            ['hash' => ''],
            $data,
            ['field' => $this, 'value' => $value, 'isCloning' => $this->isCloning]
        );

        return view('argon::fields.type.button', $data)->render();
    }
}
