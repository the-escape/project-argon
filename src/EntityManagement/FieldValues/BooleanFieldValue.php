<?php

namespace Escape\Argon\EntityManagement\FieldValues;

class BooleanFieldValue extends AbstractFieldValue
{
    public function isTrue()
    {
        if(is_array($this->data))
        {
            foreach($this->data as $data)
            {
                return $data == 1;
            }
        }

        return $this->data == 1;
    }

    public function isFalse()
    {
        return !$this->isTrue();
    }

    public function isEmpty()
    {
        // This value is never empty, but we return true to prevent multicombo value from spitting out false on isEmpty if the boolean field is present
        return true;
    }
}
