<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\EntityField;
use Escape\Argon\EntityManagement\Eloquent\FieldData;

abstract class AbstractFieldType
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $key;

    /** @var array */
    protected $properties;

    protected $field;

    protected $isCloning = false;

    public function getId()
    {
        return $this->field->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFieldName()
    {
        return $this->field->name;
    }

    public function getFieldSlug()
    {
        return $this->field->field_slug;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setIsCloning($isCloning = true)
    {
        $this->isCloning = $isCloning;
    }

    public function getProperties()
    {
        foreach ($this->properties as $name => $property) {
            if (array_key_exists('children', $property)) {
                foreach ($property['children'] as $child_name => &$child_property) {
                    $child_property = (object)$child_property;
                }
            }

            yield $name => (object)$property;
        }
    }

    public function getProperty($name)
    {
        if (!array_key_exists($name, $this->properties)) {
            return null;
        } else {
            return (object)$this->properties[$name];
        }
    }

    public function getDefaultSettings()
    {
        $settings = new \stdClass();
        foreach ($this->getProperties() as $name => $property) {
            if (property_exists($property, 'default')) {
                $settings->{$name} = $property->default;
            } else {
                $settings->{$name} = null;
            }
            if (property_exists($property, 'children')) {
                foreach ($property->children as $child_name => $child_property) {
                    if (property_exists($child_property, 'default')) {
                        $settings->{$child_name} = $child_property->default;
                    }
                }
            }
        }
        return $settings;
    }

    public function parseSettings($input)
    {
        $settings = new \stdClass();
        foreach ($this->getProperties() as $name => $property) {
            if (isset($input[$name])) {
                switch ($property->type) {
                    case 'integer':
                        $settings->$name = intval($input[$name], 10);
                        break;
                    case 'boolean':
                        $settings->$name = (bool)$input[$name];
                        break;
                    default:
                        $settings->$name = $input[$name];
                        break;
                }
            } elseif (property_exists($property, 'default')) {
                $settings->$name = $property->default;
            }
        }

        return $settings;
    }

    public function getSetting($settingName)
    {
        return (@$this->getSettings()->$settingName);
    }

    public function getSettings()
    {
        $settings = $this->field->settings;

        foreach ($this->properties as $prop => $config) {
            if (isset($settings->$prop)) {
                if ($config['type'] == 'boolean') {
                    $settings->$prop = (bool)$settings->$prop;
                } elseif ($config['type'] == 'integer') {
                    $settings->$prop = (integer)$settings->$prop;
                }
            } else {
                $settings->$prop = $config['default'];
            }
        }

        return $settings;
    }

    public function allowMultiple()
    {
        return (bool)$this->getSetting('multiple');
    }

    public function allowMultipleInstances()
    {
        return (bool)$this->getSetting('multiple_instances');
    }

    public function isRequired()
    {
        return (bool)$this->getSetting('required');
    }

    public function setField(EntityField $field)
    {
        $this->field = $field;
        return $this;
    }

    public function getParentId()
    {
        return (int)$this->field->parent_field_id;
    }

    public function isInCombo()
    {
        return $this->getParentId() != 0;
    }

    public function getFormFieldName($hash)
    {
        if ($this->isInCombo()) {
            return "combo[{$this->getParentId()}][$hash][fields][{$this->getId()}]";
        } else {
            return "fields[{$this->getId()}]";
        }
    }

    public function getCamelString($hash)
    {
        if ($this->isInCombo()) {
            return "combo.{$this->getParentId()}.{$hash}.fields.{$this->getId()}";
        } else {
            return "fields.{$this->getId()}";
        }
    }

    public function getInitialValue()
    {
        return null;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getFieldWithValues($group, $page = null , $localisation = null, $currentRevision = null, $isSubField = false)
    {
        $data = [
            'id' => $this->getId(),
            'options' => [
                'typeKey' => $this->getKey(),
                'name' => $this->getFieldName(),
                'settings' => $this->getSettings()
            ],
            'helpText' => '',
            'message' => '',
            'messageAfter' => '',
        ];

        if ($this->getKey() === 'combo')
        {
            $subfields = [];

            foreach($this->getSubFields() as $subfield)
            {
                $subfields[] = $subfield->getFieldWithValues($group, $page, $localisation, $currentRevision, true);
            }

            $data['fields'] = $subfields;
        }

        if ($this->getKey() === 'wysiwyg')
        {
            $toolbar = $format_tags = [];
            foreach($this->getProperties() as $name => $property)
            {
                if (property_exists($this->getSettings(), $name) && property_exists($property, 'toolbar'))
                {
                    if ($this->getSetting($name))
                    {
                        $toolbar[] = $property->toolbar;
                    }

                    if (($name == 'format') && $property->children)
                    {
                        foreach($property->children as $child_name => $child_propery)
                        {
                            if ($this->getSetting($child_name))
                            {
                                $format_tags[] = $child_name;
                            }
                        }
                    }
                }
            }

            $typographyStyles = config('argon.typography_styles','/css/typography.css');
            if (in_array('Styles', $toolbar) && !file_exists(public_path($typographyStyles)))
            {
                $key = array_search('Styles', $toolbar);
                unset($toolbar[$key]);
            }

            $data['options']['settings']->editor_options = [
                'toolbar' => implode(',',$toolbar),
                'format-tags' => implode(';', $format_tags),
                'height' => $this->getSetting('height'),
                'extra-allowed-content' => $this->getSetting('iframe'),
                'typography-styles' => $typographyStyles
            ];
        }

        if(!$isSubField)
        {
            $data['values'] = [];
            $data['errors'] = [];
        }

        if ($currentRevision)
        {
            $values = $currentRevision->getField($this->getId());
        }
        else
        {
            // TODO: get old / submitted values

            $fieldArray = $this->getKey() === 'combo' ? 'combo' : 'fields';
            $submitted = old($fieldArray.'.' . $this->getId());
            $values = $this->parseData($submitted);
        }

        if ($page && $localisation)
        {
            $event = event(new \Escape\Argon\Events\RenderField($this, $values, $group, $page, $localisation));
        }

        if ($values)
        {
            $data['values'] = $this->prepareValuesForForm($values);
        }

        $message = null;
        $messageAfter = null;

        if(isset($event[0]->fieldHtml))
        {
            $data['message'] = $event[0]->fieldHtml;
        }
        elseif (isset($event[0]->message))
        {
            $data['message'] = $event[0]->message;
        }

        if (isset($event[0]->messageAfter))
        {
            $data['messageAfter'] = $event[0]->messageAfter;
        }


        return $data;
    }

    public function prepareValuesForForm($values)
    {
        $returnValues = [];

        switch($this->getKey())
        {
            case 'location':
                $tmpValues = (array) $values->getData();

//                print_r($tmpValues); exit;

                foreach($tmpValues as $tmpVal)
                {
                    if ($tmpVal instanceof \stdClass)
                    {
                        $returnValues[] = [
                            'latitude' => $tmpVal->latitude,
                            'longitude' => $tmpVal->longitude,
                        ];
                    }
                    else
                    {
                        $returnValues[] = [
                            'latitude' => $tmpVal->getLatitude(),
                            'longitute' => $tmpVal->getLongitude(),
                        ];

                    }
                }
                break;
            case 'button':
                $tmpValues = (array) $values->getData();
                foreach($tmpValues as $tmpVal)
                {
                    $returnValues[] = [
                        'label' => $tmpVal->label,
                        'url' => $tmpVal->url,
                        'class' => !empty($tmpVal->class) ? $tmpVal->class : '',
                        'id' => !empty($tmpVal->id) ? $tmpVal->id : '',
                        'target' => !empty($tmpVal->target) ? $tmpVal->target : '',
                    ];
                }
                break;
            case 'image':
                foreach($values as $tmpVal)
                {
                    if($tmpVal)
                    {
                        $returnValues[] = [
                            'id' => $tmpVal->getId(),
                            'width' => $tmpVal->getWidth(),
                            'height' => $tmpVal->getHeight(),
                            'alt' => $tmpVal->getAlt(),
                            'url' => $tmpVal->getUrl(),
                        ];
                    }
                    else
                    {
                        $returnValues[] = [
                            'id' => '',
                            'width' => '',
                            'height' => '',
                            'alt' => '',
                            'url' => '',
                        ];
                    }
                }
                break;
            case 'file':
                foreach($values as $tmpVal)
                {
                    if($tmpVal)
                    {
                        $returnValues[] = [
                            'id' => $tmpVal->getId(),
                            'url' => $tmpVal->getUrl(),
                        ];
                    }
                    else
                    {
                        $returnValues[] = [
                            'id' => '',
                            'url' => '',
                        ];
                    }

                }
                break;
            case 'combo':
                $tmpValues = (array) $values->getData();

                foreach($tmpValues as $tmpVal)
                {
                    $tmpArr = [];

                    foreach ($this->getSubfields() as $subfield)
                    {
                        $subId = $subfield->getField()->id;
                        $vals = !empty($tmpVal->fields) && array_key_exists($subId, $tmpVal->fields) ? $tmpVal->fields[$subId] : [];
                        $sf = $subfield->parseData($vals);

                        $tmpArr[$subId] = $subfield->prepareValuesForForm($sf);
                    }

                    $returnValues[] = $tmpArr;
                }

                break;
            case 'item':
                $tmpValues = (array) $values->getData();

                foreach($tmpValues as $tmpVal)
                {
                    $returnValues[] = (string) $tmpVal;
                }

                break;
            default:
                $returnValues = (array) $values->getData();
                break;
        }

        return $returnValues;
    }

    abstract public function parseData($data);

    abstract public function render($value = null, $data = []);
}
