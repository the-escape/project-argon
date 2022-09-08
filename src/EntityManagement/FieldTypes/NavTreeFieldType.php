<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\TextFieldValue;

class NavTreeFieldType extends AbstractFieldType
{
    protected $name = 'Nav Tree';

    protected $key = 'navtree';

    protected $group;

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
    ];

    public function parseData($data = null)
    {
        if ($data instanceof FieldData)
        {
            return new TextFieldValue($data->value);
        }

        return new TextFieldValue($data);
    }

    public function isMultiline()
    {
        return (bool)$this->getSetting('multiline');
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
                $value = new TextFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new TextFieldValue();
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

        if ($this->isMultiline()) {
            return view('argon::fields.type.textarea', $data)->render();
        } else {
            return view('argon::fields.type.text', $data)->render();
        }
    }
}
