<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Exception;

class TextFieldValue extends AbstractFieldValue implements \IteratorAggregate, \Countable
{
    public function __toString()
    {
        if(class_exists('App\Plugins\FormBuilder\Eloquent\FormBuilder')){
            \App\Plugins\FormBuilder\Eloquent\FormBuilder::replaceShortcodes($this->data);
        }

        if (is_array($this->data)) {
            return implode(PHP_EOL, $this->data);
        } elseif ($this->data) {
            return (string) $this->data;
        } else {
            return "";
        }
    }

    #[\ReturnTypeWillChange]
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
    
    #[\ReturnTypeWillChange]
    public function count()
    {
        if (is_array($this->data))
        {
            return count($this->data);
        }

        if (($this->data === '') || ($this->data === null)) {
            return 0;
        }

        return 1;
    }
}
