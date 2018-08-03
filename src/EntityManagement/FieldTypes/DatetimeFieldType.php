<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\DatetimeFieldValue;
use Faker\Provider\cs_CZ\DateTime;

class DatetimeFieldType extends AbstractFieldType
{
    protected $name = 'Datetime';

    protected $key = 'datetime';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'time' => [
            'label' => 'Include Time',
            'type' => 'boolean',
            'default' => true,
            'help' => "Allow the user to select a time.",
        ],
        'seconds' => [
            'label' => 'Include Seconds in time field',
            'type' => 'boolean',
            'default' => false,
            'help' => "",
        ],
        'default' => [
            'label' => 'Default to current time?',
            'type' => 'boolean',
            'default' => true,
            'help' => "",
        ],
    ];

    public function getFormFieldName($hash)
    {
        return parent::getFormFieldName($hash) . '[]';
    }

    public function parseData($data = null)
    {
        if ($data instanceof FieldData)
        {
            return new DatetimeFieldValue($data->value);
        }

        return new DatetimeFieldValue($data);
    }

    public function timeEnabled()
    {
        return (boolean)$this->getSetting('time');
    }

    public function secondsEnabled()
    {
        return (boolean)$this->getSetting('seconds');
    }

    public function render($value = null, $data = [])
    {
        if (!$this->isInCombo()) {
            $submitted = old('fields.' . $this->getId());
            if ($submitted !== null) {
                $value = new DatetimeFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new DatetimeFieldValue();
        }

        $data = array_merge(
            ['hash' => ''],
            $data,
            ['field' => $this, 'value' => $value, 'isCloning' => $this->isCloning]
        );

        return view('argon::fields.type.datetime', $data)->render();
    }
}
