<?php

namespace Escape\Argon\EntityManagement\DataMappers;


use Escape\Argon\EntityManagement\Eloquent\EntityCache;
use InvalidArgumentException;

/**
 * Class DataMapper
 * @package Escape\Argon\EntityManagement\DataMappers
 *
 * Extend this class to conveniently map the data, in most cases AbstractFieldValue,
 * into more friendly and specific objects with specialised methods.
 *
 * DataMapper class provides basic getters, setters, hasProperty, isEmpty methods.
 * These are generic methods, more specific implementation should be applied
 * on final objects extending DataMapper.
 *
 * Field mapping is based on class properties, like so:
 *
 * class SocialLinks extends DataMapper
 * {
 *     protected $facebook;
 *     protected $linkedin;
 *     protected $pinterest;
 *     protected $twitter;
 *     protected $instagram;
 *     protected $youtube;
 *
 *     public function __construct($data)
 *     {
 *         if ($data instanceof ComboFieldValue)
 *         {
 *             foreach ($data as $array)
 *             {
 *                 $this->mapArray($array);
 *                 return;
 *             }
 *         }
 *
 *         if (is_array($data))
 *         {
 *             $this->mapArray($data);
 *             return;
 *         }
 *     }
 * }
 *
 *
 *
 */
class DataMapper
{
    protected $DataMapper__Key;
    protected $DataMapper__KeyMapFormat = "%s:%d";
    protected $DataMapper__KeyRegex = '/^[1-9][0-9]*$/';

    /**
     * Maps $cache fields/combos to class properties.
     * For more effective combo mapping see Combo class and MultiCombo class.
     * @param EntityCache $cache
     */
    protected function map(EntityCache $cache)
    {
        $properties = $this->getClassProperties();

        foreach ($properties as $property)
        {
            $field = is_null($this->DataMapper__Key)
                ? $property
                : sprintf($this->DataMapper__KeyMapFormat, $property, $this->DataMapper__Key);

            if ($cache->fieldExists($field))
            {
                $setter = $this->setter($property);
                $this->$setter($cache->field($field));
            }
        }
    }

    /**
     * Maps $cache combo fields to class properties.
     * @param array $data
     */
    protected function mapArray(array $data)
    {
        $properties = $this->getClassProperties();

        foreach ($properties as $property)
        {
            if (isset($data[$property]))
            {
                $setter = $this->setter($property);
                $this->$setter($data[$property]);
            }
        }
    }

    protected function setDataMapperKey($key=null)
    {
        if (!is_null($key))
        {
            if (!preg_match($this->DataMapper__KeyRegex, $key))
            {
                throw new InvalidArgumentException(sprintf("Invalid `key` agrument. Expected integer, received %s", $key));
            }

            $this->DataMapper__Key = (int)$key;
        }
    }

    protected function getClassProperties()
    {
        // caching variable for performance
        if (isset($this->DataMapper__ClassProperties))
        {
            return $this->DataMapper__ClassProperties;
        }

        $properties = get_class_vars(static::class);

        foreach ($properties as $k => $v)
        {
            if ((strpos($k, "DataMapper__") === 0))
            {
                unset($properties[$k]);
            }
        }

        $this->DataMapper__ClassProperties = array_keys($properties);

        return $this->DataMapper__ClassProperties;
    }

    /**
     * Processes given property into usable camelcase method name.
     * Supported properties can have '-', '_', ':' symbols in their name.
     * @param $property
     * @return mixed
     */
    protected function prepPropertyLabel($property)
    {
        $label = ucwords(str_replace(['-', '_', ':'], ' ', $property));
        return str_replace(' ', '', $label);
    }

    /**
     * Prepare setter label from given property.
     * @param $property
     * @return string
     */
    protected function setter($property)
    {
        return sprintf("set%s", $this->prepPropertyLabel($property));
    }

    /**
     * Prepare setter label from given property.
     * @param $property
     * @return string
     */
    protected function getter($property)
    {
        return sprintf("get%s", $this->prepPropertyLabel($property));
    }

    /**
     * Prepare hasProperty label from given property.
     * Used to assert if property has value, like $object->hasImage() etc.
     * @param $property
     * @return string
     */
    protected function hasAssertion($property)
    {
        return sprintf("has%s", $this->prepPropertyLabel($property));
    }

    /**
     * This magic method provides access to "getPropery()", "setProperty(), and "hasProperty()" - which is an empty check.
     * It eliminates basic, repetitive getters, setters, and "has" value assertions for properties of the DataMapper object.
     * More specific methods need to be placed of corresponding objects.
     * Ref: http://php.net/manual/en/language.oop5.overloading.php#object.call
     *
     * @param $method
     * @param $arguments array
     * @return bool|null
     */
    public function __call($method, $arguments)
    {
        $properties = $this->getClassProperties();

        foreach ($properties as $property)
        {
            $getter = $this->getter($property);

            if ($method == $getter)
            {
                return $this->$property;
            }

            $setter = $this->setter($property);

            if ($method == $setter)
            {
                $this->$property = $arguments[0];
                break;
            }

            $assertion = $this->hasAssertion($property);

            if ($method == $assertion)
            {
                if (is_null($this->$property))
                {
                    return false;
                }

                if ($this->$property === '')
                {
                    return false;
                }

                // isEmpty method equivalent
                if (is_array($this->$property))
                {
                    return (bool) count($this->$property);
                }

                if (is_object($this->$property))
                {
                    //$this->$property instanceof AbstractFieldValue or CacheMediaItemValue or Collection
                    if (method_exists($this->$property, "isEmpty"))
                    {
                        if ($this->$property->isEmpty())
                        {
                            return false;
                        }
                    }
                }

                return true;
            }
        }

        return null;
    }

    /**
     * Evaluates each class property checking if value is not null and not empty string.
     * Uses hasProperty() method via magic method __call or object's native hasProperty() method if exists.
     *
     * @return bool
     */
    public function isEmpty()
    {
        foreach ($this->getClassProperties() as $property)
        {
            $hasAssertion = $this->hasAssertion($property);

            if ($this->$hasAssertion())
            {
                return false;
            }
        }

        return true;
    }
}
