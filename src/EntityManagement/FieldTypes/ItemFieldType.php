<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityCache;
use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldValues\ItemFieldValue;
use Cache;
class ItemFieldType extends AbstractFieldType
{
    protected $name = 'Item';

    protected $key = 'item';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'multiple' => [
            'label' => 'Multiple select dropdown',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allow selecting multiple items through one dropdown.",
        ],
        'multiple_instances' => [
            'label' => 'Standard select field - multiple instances.',
            'type' => 'boolean',
            'default' => false,
            'help' => "Single selection multiple times.",
        ],
        'items' => [
            'label' => 'Items',
            'type' => 'items',
            'default' => '',
            'help' => "",
        ],
    ];

    public function getSettings()
    {
        $settings = parent::getSettings();

        $items = is_array($settings->items) ? $settings->items : [$settings->items];
        $entityRepository = app()->make(EntityRepository::class);
        $options = EntityCache::whereIn('entity_type_id', $items)->select('entity_id','entity_name','entity_url')->orderBy('entity_name')->get();

        $opts = [];
        foreach($options as $opt)
        {
            $name = $opt->entity_name;
            if($opt->entity_url)
            {
                $slugArray = explode('/', $opt->entity_url);
                $sep = '/';
                $slugStr = sprintf('/%s', $slugArray[1]);
                if(count($slugArray) > 2)
                {
                    if(count($slugArray) > 3)
                    {
                        $sep = '/.../';
                    }

                    $slugStr = sprintf('/%s%s%s', $slugArray[1], $sep, end($slugArray));
                }
                $name .= sprintf(' (%s)', $slugStr);
            }
            $opts[] = (object) [$opt->entity_id => $name];
        }

        $settings->options =  $opts;

        return $settings;
    }

    public function parseData($data = null)
    {
        if ($data instanceof FieldData)
        {
            return new ItemFieldValue($data->value);
        }

        return new ItemFieldValue($data);
    }


    public function getOptions()
    {
        $contentTypeIds = $this->getSetting('items');
        if (!is_array($contentTypeIds)) {
            $contentTypeIds = [$contentTypeIds];
        }
        /** @var EntityRepository $entityRepository */
        $entityRepository = app()->make(EntityRepository::class);
        $options = $entityRepository->findWhereIn('entity_type_id', $contentTypeIds);
        return $options;
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
                $value = new ItemFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new ItemFieldValue();
        }

        $data = array_merge(
            ['hash' => ''],
            $data,
            ['field' => $this, 'value' => $value, 'isCloning' => $this->isCloning]
        );

        return view('argon::fields.type.item', $data)->render();
    }

    public function renderHidden($value = null, $data = [])
    {
        if (!$this->isInCombo()) {
            $submitted = old('fields.' . $this->getId());
            if ($submitted !== null) {
                $value = new ItemFieldValue($submitted);
            }
        }

        if ($value === null) {
            $value = new ItemFieldValue();
        }

        $data = array_merge(
            ['hash' => ''],
            $data,
            ['field' => $this, 'value' => $value]
        );

        return view('argon::fields.type.hidden.item', $data)->render();
    }
}
