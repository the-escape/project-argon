<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

class AbstractFieldType
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
            yield $name => (object)$property;
        }
    }

    public function getDefaultSettings()
    {
        $settings = new \stdClass();
        foreach ($this->getProperties() as $name => $property) {
            if (property_exists($property, 'default')) {
                $settings->$name = $property->default;
            }
        }
        return $settings;
    }


}
