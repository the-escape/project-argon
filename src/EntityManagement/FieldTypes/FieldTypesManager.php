<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

class FieldTypesManager
{
    protected $fieldTypes = [];

    public function getFieldTypes()
    {
        return $this->fieldTypes;
    }

    /**
     * @param $type
     * @return AbstractFieldType
     */
    public function getType($type)
    {
        return $this->fieldTypes[$type];
    }

    public function registerFieldType(AbstractFieldType $fieldType)
    {
        $this->fieldTypes[$fieldType->getKey()] = $fieldType;
    }
}
