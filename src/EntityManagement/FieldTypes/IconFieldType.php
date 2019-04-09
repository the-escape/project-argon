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
        ],
        'meta_path' => [
            'label' => 'Override the default svgmeta. ',
            'type' => 'text',
            'default' => null,
            'help' => "Provide a path to a different svgmeta.json file (relative to public folder)."
        ],
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
        $settings->svg_path = config('argon.svgicons_path','/images/svgicons.svg');

        if(empty($settings->meta_path))
        {
            $settings->meta_path = config('argon.svgicons_meta','/images/svgmeta.json');
        }

        return $settings;
    }

    public function render($value = null, $data = [])
    {
        // todo
    }
}
