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
}
