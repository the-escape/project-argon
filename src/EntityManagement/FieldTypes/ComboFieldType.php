<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\ComboFieldValue;
use Illuminate\Database\Eloquent\Collection;

//use Escape\Argon\EntityManagement\FieldValues\ComboFieldValue;

class ComboFieldType extends AbstractFieldType
{
    protected $name = 'Combo';

    protected $key = 'combo';

    protected $group;

    protected $properties = [
        'multiple' => [
            'label' => 'Multiple',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allow multiple instances of a field (cloning).",
        ],
    ];

    public function getSubfields()
    {
        /** @var Collection $subfields */
        $subfields = $this->field->subfields;
        $subfields = $subfields->map(function($f) { return $f->type; });

        return $subfields;
    }

    public function parseData(FieldData $data)
    {
        return new ComboFieldValue($data->value);
    }
}
