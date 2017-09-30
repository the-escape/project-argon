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

    abstract public function parseData($data);

    abstract public function render($value = null, $data = []);
}
