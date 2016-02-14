<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\ComboFieldValue;
use Illuminate\Database\Eloquent\Collection;

class ComboFieldType extends AbstractFieldType
{
    protected $name = 'Combo';

    protected $key = 'combo';

    protected $group;

    protected $properties = [
//        'required' => [
//           'label' => 'Required?',
//            'type' => 'boolean',
//            'default' => false,
//            'help' => null,
//        ],
        'multiple' => [
            'label' => 'Multiple',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allow multiple instances of a field (cloning).",
        ],
    ];

    public function getSubFields()
    {
        /** @var Collection $subFields */
        $subFields = $this->field->subfields;
        $subFields = $subFields->map(
            function ($f) {
                return $f->type;
            }
        );

        return $subFields;
    }

    public function parseData(FieldData $data)
    {
        return new ComboFieldValue($data->value, $this->getSubfields());
    }

    public function render($value = null, $data = [])
    {
        if ($submitted = old('combo.' . $this->getId())) {
            $value = new ComboFieldValue($submitted, $this->getSubfields());
        }

        if ($value === null) {
            $hash = guid();
            $value = new ComboFieldValue([$hash => (object)['fields' => []]], $this->getSubfields());
        }

        $data = array_merge($data, ['field' => $this, 'value' => $value, 'isCloning' => $this->isCloning]);
        return view('argon::fields.type.combo', $data)->render();
    }
}
