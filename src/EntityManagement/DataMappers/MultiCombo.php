<?php

namespace Escape\Argon\EntityManagement\DataMappers;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Escape\Argon\EntityManagement\FieldValues\ComboFieldValue;
use IteratorAggregate;
use Traversable;

/**
 * Class MultiCombo handles multiple combo instances providing convenient abstraction using
 * following SPL interfaces IteratorAggregate, Countable, ArrayAccess, and native isEmpty check.
 *
 * This means combos mapped using MultiCombo class can be accessed, counted and iterated over just like arrays.
 *
 * When accessing/iterating over nested combos, each one is an instance of given/passed custom ClassName::class object
 * that extends Combo class providing all convenient methods of that class.
 *
 * class Example extends DataMapper
 * {
 *     protected $textfield;
 *     protected $combos;
 *
 *     public function __construct(EntityCache $cache)
 *     {
 *         $this->map($cache);
 *         $this->combos = new MultiCombo(MyCombo::class, $cache->combo("combo", null, true));
 *     }
 * }
 *
 * @package Escape\Argon\EntityManagement\DataMappers
 */
class MultiCombo implements IteratorAggregate, Countable, ArrayAccess
{
    protected $combos = [];

    /**
     * @param $classname, use class name resolution via ::class, like so: ClassName::class
     * @param ComboFieldValue|null $comboFieldValue
     */
    public function __construct($classname, ComboFieldValue $comboFieldValue=null)
    {
        if (!is_null($comboFieldValue))
        {
            foreach ($comboFieldValue as $cfv)
            {
                $this->combos[] = new $classname($cfv);
            }
        }
    }

    public function isEmpty()
    {
        foreach ($this->combos as $combo)
        {
            if (!$combo->isEmpty())
            {
                return false;
            }
        }

        return true;
    }

    /**
     * IteratorAggregate implementation.
     *
     * @return ArrayIterator
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->combos);
    }

    /**
     * Countable implementation.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->combos);
    }

    /**
     * Magic access method for accessing combos by field key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (!isset($this->combos[$key])) {
            return;
        }

        return $this->combos[$key];
    }

    /**
     * Magic access method for setting combos by key.
     *
     * @param string $key
     * @param Combo $value
     *
     * @return mixed
     */
    public function __set($key, ?Combo $value)
    {
        return $this->combos[$key] = $value;
    }

    /**
     * Check if combo is set by key.
     *
     * Magic method for checking if combos are set by combo key.
     *
     * @param string $key
     *
     * @return boolean
     */
    public function __isset($key)
    {
        return isset($this->combos[$key]);
    }

    /**
     * ArrayAccess implementation.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->__set($offset, $value);
    }

    /**
     * ArrayAccess implementation.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return ($this->__get($offset) !== null);
    }

    /**
     * ArrayAccess implementation.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        $this->__set($offset, null);
    }

    /**
     * ArrayAccess implementation.
     *
     * @param mixed $offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset): mixed
    {
        return $this->__get($offset);
    }
}

