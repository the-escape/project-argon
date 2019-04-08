<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\IconFieldValue;

class IconFieldType extends AbstractFieldType
{
    protected $name = 'Icon';

    protected $key = 'icon';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ]
    ];

    public function parseData($data = null)
    {
        if ($data instanceof FieldData)
        {
            return new IconFieldValue($data->value);
        }

        return new IconFieldValue($data);
    }

    public function getSettings()
    {
        $settings = parent::getSettings();
        $settings->meta_path = config('argon.svgicons_meta','/images/svgmeta.json');
        return $settings;
    }

    public function render($value = null, $data = [])
    {
        // todo
    }
}
