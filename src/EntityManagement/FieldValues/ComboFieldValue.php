<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\EntityManagement\FieldTypes\AbstractFieldType;
use Illuminate\Support\Collection;
use stdClass;
use Traversable;

class ComboFieldValue extends AbstractFieldValue implements \IteratorAggregate, \Countable
{
    /** @var Collection */
    protected $subfields;

    public function __construct($data, $subfields = null)
    {
        $newData = [];
        if ($data) {
            foreach ($data as $k => $v) {
                $newV = new stdClass();
                $newV->fields = [];
                $v = (array) $v;
                foreach ($v['fields'] as $fk => $fv) {
                    $newV->fields[$fk] = $fv;
                }
                $newData[$k] = $newV;
            }
        }

        parent::__construct($newData);

        if (is_null($subfields)) {
            $subfields = new Collection();
        }
        $this->subfields = $subfields;
    }

    public function __toString()
    {
        if ($this->isEmpty()) {
            return '';
        }

        $string = [];

        foreach ($this as $subfields) {
            if (is_array($subfields)) {
                foreach ($subfields as $subfield) {
                    if (!$subfield instanceof AbstractFieldValue) {
                        continue;
                    }
                    if (!$subfield->isEmpty()) {
                        $string[] = (string) $subfield;
                    }
                }
            }
        }

        return json_encode($string);
    }

    public function count()
    {
        return count($this->data);
    }

    /**
     * Retrieve an external iterator.
     *
     * @see http://php.net/manual/en/iteratoraggregate.getiterator.php
     *
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     *                     <b>Traversable</b>
     *
     * @since 5.0.0
     */
    public function getIterator()
    {
        $data = [];

        if (null !== $this->data) {
            foreach ($this->data as $k => $v) {
                $data[$k] = [];

                foreach ($v->fields as $id => $d) {
                    // check if handling cached combo
                    if ($this->subfields->isEmpty() && $this->data) {
                        if ($k) {
                            if (array_key_exists($k, $this->data)) {
                                $currentIteration = $this->data[$k];
                            } else {
                                throw new \RuntimeException("Requested field '{$id}' doesn't have offset '{$k}'.");
                            }
                        } else {
                            $currentIteration = @array_values($this->data)[0];
                        }

                        if (is_object($currentIteration) && property_exists($currentIteration, 'fields') && array_key_exists($id, $currentIteration->fields)) {
                            $value = $currentIteration->fields[$id]->value;
                        } else {
                            $value = null;
                        }

                        $fieldType = app('fieldTypes')->getType($currentIteration->fields[$id]->type);
                        $fieldValue = $fieldType->parseData($value);
                        $data[$k][$id] = $fieldValue;

                        continue;
                    }

                    // added to allow easy access while looping through multiple combos
                    $field = $this->subfields->first(
                        function ($i, $f) use ($id) {
                            return $f->getId() == $id;
                        }
                    );
                    if ($field instanceof AbstractFieldType) {
                        $data[$k][$field->getFieldSlug()] = $this->field($field->getFieldSlug(), $k);
                    }
                }
            }
        }

        return new \ArrayIterator($data);
    }

    public function getValueForSubField($hash, $fieldId)
    {
        $field = $this->subfields->first(
            function ($i, $f) use ($fieldId) {
                return $f->getId() == $fieldId;
            }
        );

        $instance = $this->data[$hash];
        $fieldData = new FieldData();
        if (array_key_exists($fieldId, $instance->fields)) {
            $fieldData->value = $instance->fields[$fieldId];
        } else {
            $fieldData->value = $field->getInitialValue();
        }

        return $field->parseData($fieldData);
    }

    public function first()
    {
        if (is_array($this->data) && (count($this->data) > 1)) {
            $this->data = array_slice($this->data, 0, 1);

            return $this;
        }

        return $this;
    }

    public function field($fieldName, $k = null)
    {
        // check if handling cached combo
        if ($this->subfields->isEmpty() && $this->data) {
            if ($k) {
                if (array_key_exists($k, $this->data)) {
                    $currentIteration = $this->data[$k];
                } else {
                    throw new \RuntimeException("Requested field '{$fieldName}' doesn't have offset '{$k}'.");
                }
            } else {
                $currentIteration = @array_values($this->data)[0];
            }

            if (is_object($currentIteration) && property_exists($currentIteration, 'fields') && array_key_exists($fieldName, $currentIteration->fields)) {
                $value = $currentIteration->fields[$fieldName]->value;
            } else {
                $value = null;
            }

            $fieldType = app('fieldTypes')->getType($currentIteration->fields[$fieldName]->type);

            return $fieldType->parseData($value);
        }

        /** @var AbstractFieldType $field */
        $field = $this->subfields->first(
            function ($i, AbstractFieldType $f) use ($fieldName) {
                return $f->getFieldSlug() == $fieldName;
            }
        );

        if (!$field) {
            throw new \RuntimeException("Undefined field '{$fieldName}'.");
        }

        if ($k) {
            if (array_key_exists($k, $this->data)) {
                $currentIteration = $this->data[$k];
            } else {
                throw new \RuntimeException("Requested field '{$fieldName}' doesn't have offset '{$k}'.");
            }
        } else {
            reset($this->data);
            $currentIteration = current($this->data);
        }

        if (is_object($currentIteration) && property_exists($currentIteration, 'fields') && array_key_exists($field->getId(), $currentIteration->fields)) {
            $value = $currentIteration->fields[$field->getId()];
        } else {
            $value = $field->getInitialValue();
        }

        $fieldData = new FieldData();
        $fieldData->value = $value;

        return $field->parseData($fieldData);
    }

    public function fieldExists($field_slug)
    {
        // check if handling cached combo
        if ($this->subfields->isEmpty() && $this->data) {
            $currentIteration = @array_values($this->data)[0];
            if (is_object($currentIteration) && property_exists($currentIteration, 'fields') && array_key_exists($field_slug, $currentIteration->fields)) {
                return true;
            }

            return false;
        }

        // legacy check if handling page combo
        $fields = $field = $this->subfields;
        foreach ($fields as $field) {
            $fs = $field->getField()->field_slug;
            if ($field_slug == $fs) {
                return true;
            }
        }

        return false;
    }

    public function isEmpty()
    {
        foreach ($this as $subfields) {
            if (is_array($subfields)) {
                foreach ($subfields as $subfield) {
                    if (!$subfield instanceof AbstractFieldValue) {
                        continue;
                    }
                    if (!$subfield->isEmpty()) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public function compress()
    {
        $values = [];

        // check if handling cached combo
        if ($this->subfields->isEmpty() && $this->data) {
            foreach ($this->data as $subfields) {
                $subfieldValues = [];

                foreach ($subfields->fields as $subfieldKey => $subfieldValue) {
                    $subfieldValues[$subfieldKey] = $subfieldValue->value;
                }
                $values[] = $subfieldValues;
            }
        } else {
            foreach ($this as $subfields) {
                if (is_array($subfields)) {
                    $subfieldValues = [];
                    foreach ($subfields as $fieldName => $fieldValue) {
                        if (!$fieldValue instanceof AbstractFieldValue) {
                            continue;
                        }

                        $subfieldValues[$fieldName] = $fieldValue->compress();
                    }
                    $values[] = $subfieldValues;
                }
            }
        }

        return $values;
    }

    public function toJson($options = 0)
    {
        $values = $this->compress();

        return json_encode($values, $options);
    }
}
