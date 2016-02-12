<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Traversable;

class ComboFieldValue extends AbstractFieldValue implements \IteratorAggregate
{

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        $data = [];

        if ($this->data !== null) {
            foreach ($this->data as $k => $v) {
                $data[$k] = [];

                foreach ($v->fields as $id => $d) {
                    $data[$k][$id] = $d;
                }
            }
        }

        return new \ArrayIterator($data);
    }
}
