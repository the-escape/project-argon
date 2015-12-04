<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;

abstract class AbstractFieldType
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $key;

    /** @var array */
    protected $properties;

    public function getName()
    {
        return $this->name;
    }

    public function getKey()
    {
        return $this->key;
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

    public function getDefaultSettings()
    {
        $settings = new \stdClass();
        foreach ($this->getProperties() as $name => $property) {
            if (property_exists($property, 'default')) {
                $settings->{$name} = $property->default;
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

    abstract public function getValue(FieldData $data=null);
}
