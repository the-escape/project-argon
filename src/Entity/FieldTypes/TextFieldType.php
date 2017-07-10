<?php

namespace Escape\Argon\Entity\FieldTypes;

use Escape\Argon\Entity\Eloquent\FieldData;
use Escape\Argon\Entity\FieldValues\TextFieldValue;

class TextFieldType extends AbstractFieldType
{
    protected $name = 'Text';

    protected $key = 'text';

    protected $group;

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'multiline' => [
            'label' => 'Multiline',
            'type' => 'boolean',
            'default' => false,
            'help' => 'Display field as textarea',
        ],
        'multiple' => [
            'label' => 'Multiple',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allow multiple instances of a field (cloning).",
        ],
        'minlength' => [
            'label' => 'Minimum Length',
            'type' => 'integer',
            'default' => null,
            'help' => null,
        ],
        'maxlength' => [
            'label' => 'Maximum Length',
            'type' => 'integer',
            'default' => null,
            'help' => null,
        ],
        'url' => [
            'label' => 'Validate as url?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
        'integer' => [
            'label' => 'Validate as integer?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
        'float' => [
            'label' => 'Validate as floating point number?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
        'email' => [
            'label' => 'Validate as email?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
        'phone' => [
            'label' => 'Validate as phone number?',
            'type' => 'boolean',
            'default' => null,
            'help' => null,
        ],
    ];

    public function parseData(FieldData $data = null)
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
