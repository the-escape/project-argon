<?php

namespace Escape\Argon\EntityManagement\FieldValues;

class NavTreeFieldValue extends AbstractFieldValue implements \IteratorAggregate, \Countable
{
    public function __toString()
    {
        if (is_array($this->data)) {
            return implode(PHP_EOL, $this->data);
        } elseif ($this->data) {
            return (string) $this->data;
        } else {
            return "";
        }
    }

    public function getIterator()
    {
        if ($this->data == null) {
            $data = [''];
        } else {
            $data = $this->data;
        }

        if (!is_array($data)) {
            $data = [$data];
        }

        return new \ArrayIterator($data);
    }

    public function count()
    {
        return count($this->data);
    }
}
