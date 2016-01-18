<?php

namespace Escape\Argon\EntityManagement\FieldValues;

class BooleanFieldValue extends AbstractFieldValue
{
    public function isTrue()
    {
        return $this->data == 1;
    }

    public function isFalse()
    {
        return !$this->isTrue();
    }
}
