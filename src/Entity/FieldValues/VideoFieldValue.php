<?php

namespace Escape\Argon\Entity\FieldValues;

class VideoFieldValue extends AbstractFieldValue implements \IteratorAggregate
{
    public function __toString()
    {
        if (is_array($this->data)) {
            return implode(PHP_EOL, $this->data);
        } elseif ($this->data) {
            return $this->data;
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
}
