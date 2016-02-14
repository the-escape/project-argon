<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Traversable;

class SelectFieldValue extends AbstractFieldValue implements \IteratorAggregate
{
    public function __construct($data = [0])
    {
        if (is_array($data)) {
//            $data = array_map(function($i) { return (int)$i; }, $data);
        } elseif ($data != null) {
            $data = [$data];
        } else {
            $data = [''];
        }
        parent::__construct($data);
    }

    public function getSelectedIndex()
    {
        if (!empty($this->data)) {
            return (int)$this->data[0];
        } else {
            return false;
        }

    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
}
