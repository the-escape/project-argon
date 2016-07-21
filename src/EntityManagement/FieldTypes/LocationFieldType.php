<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\LocationFieldValue;


class LocationFieldType extends AbstractFieldType
{
    protected $name = 'Location';

    protected $key = 'location';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'float' => [
            'label' => 'Validate as floating point number?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
        'multiple' => [
            'label' => 'Multiple',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allow multiple instances of a field (cloning).",
        ],
    ];

    public function parseData(FieldData $data = null)
    {
        if ($data instanceof FieldData)
        {
            return new LocationFieldValue($data->value);
        }

        return new LocationFieldValue($data);
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
                $value = new LocationFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new LocationFieldValue();
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

        return view('argon::fields.type.location', $data)->render();
    }
}
