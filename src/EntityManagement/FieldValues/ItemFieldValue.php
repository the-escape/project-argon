<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Traversable;

class ItemFieldValue extends AbstractFieldValue implements \IteratorAggregate
{
    public function __construct($data = [])
    {
        if (is_array($data)) {
            $data = array_map(function($i) { return (int)$i; }, $data);
        } else if ($data != null) {
            $data = [(int)$data];
        } else {
            $data = [];
        }
        parent::__construct($data);
    }

    public function get()
    {
        return $this->data;
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
