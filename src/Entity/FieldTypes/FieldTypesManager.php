<?php

namespace Escape\Argon\Entity\FieldTypes;

class FieldTypesManager
{
    protected $fieldTypes = [];


    /**
     * @param array $exclude field types to exclude, like 'combo', that is handled mostly as a separate type.
     * @return array
     */
    public function getFieldTypes(array $exclude = ['combo'])
    {
        $fields = array_diff_key($this->fieldTypes, array_flip($exclude));
        usort($fields, function(AbstractFieldType $a, AbstractFieldType $b) {
            return strcmp($a->getName(), $b->getName());
        });
        return $fields;
    }

    /**
     * @param $type
     * @return AbstractFieldType
     */
    public function getType($type)
    {
        return new $this->fieldTypes[$type];
    }

    public function registerFieldType(AbstractFieldType $fieldType)
    {
        $this->fieldTypes[$fieldType->getKey()] = $fieldType;
    }
}
