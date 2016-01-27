<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\DatetimeFieldValue;

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
    ];

    function parseData(FieldData $data)
    {
        return new DatetimeFieldValue($data->value);
    }

    public function timeEnabled()
    {
        return (boolean)$this->getSetting('time');
    }

    public function secondsEnabled()
    {
        return (boolean)$this->getSetting('seconds');
    }
}
