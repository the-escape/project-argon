<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\VideoFieldValue;

class VideoFieldType extends AbstractFieldType
{
    protected $name = 'Video';

    protected $key = 'video';

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
        'width' => [
            'label' => 'Width',
            'type' => 'integer',
            'default' => null,
            'help' => null,
        ],
        'height' => [
            'label' => 'Height',
            'type' => 'integer',
            'default' => null,
            'help' => null,
        ],
        'help' => [
            'label' => 'HelpText',
            'type' => 'text',
            'default' => null,
            'help' => null,
        ],
    ];

    public function parseData(FieldData $data = null)
    {
        if ($data instanceof FieldData)
        {
            return new VideoFieldValue($data->value);
        }

        return new VideoFieldValue($data);
    }


    public function render($value = null, $data = [])
    {
        if (!$this->isInCombo()) {
            $submitted = old('fields.' . $this->getId());
            if ($submitted !== null) {
                $value = new VideoFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new VideoFieldValue();
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

        return view('argon::fields.type.text', $data)->render();
    }
}
