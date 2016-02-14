<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\FileFieldValue;

class FileFieldType extends AbstractFieldType
{
    protected $name = 'File';

    protected $key = 'file';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'multiple' => [
            'label' => 'Multiple?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'formats' => [
            'label' => 'Allowed Formats',
            'type' => 'text',
            'default' => 'text/plain, text/csv, text/comma-separated-values',
            'help' => "Comma separated list of mime types. Example for CSV uploads: " .
                "text/plain, text/csv, text/comma-separated-values"
        ],
        'max_size' => [
            'label' => 'Max File Size',
            'type' => 'integer',
            'default' => 1024000,
            'help' => 'Please enter in bytes. Example for 1MB: 1024000'
        ],
        'help' => [
            'label' => 'Help Text',
            'type' => 'text',
            'default' => null,
            'help' => null,
        ],
    ];

    public function getEmptyValue()
    {
        return new FileFieldValue();
    }

    public function parseData(FieldData $data)
    {
        return new FileFieldValue($data->value);
    }

    public function render($value = null, $data = [])
    {
        if ($value === null) {
            $value = new FileFieldValue();
        }

        $data = array_merge(
            ['hash' => ''],
            $data,
            ['field' => $this, 'value' => $value, 'isCloning' => $this->isCloning]
        );

        return view('argon::fields.type.file', $data)->render();
    }
}
