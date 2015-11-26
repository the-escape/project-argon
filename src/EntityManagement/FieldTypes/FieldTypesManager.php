<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

class FieldTypesManager
{
    protected $fieldTypes = [];


    /**
     * @param array $exclude field types to exclude, like 'combo', that is handled mostly as a separate type, still a field though :)
     * @return array
     */
    public function getFieldTypes(array $exclude=['combo'])
    {
        return array_diff_key($this->fieldTypes, array_flip($exclude));
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
