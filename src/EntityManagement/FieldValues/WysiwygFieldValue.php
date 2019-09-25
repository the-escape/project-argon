<?php

namespace Escape\Argon\EntityManagement\FieldValues;

class WysiwygFieldValue extends TextFieldValue
{
    public function __construct($data = null)
    {
        if (is_object($data))
        {
            $data = (array) $data;
        }

        parent::__construct($data);
    }

    public function __toString()
    {
        return parent::__toString();
    }
}
