<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Illuminate\Support\Collection;
use MyProject\Proxies\__CG__\stdClass;
use Traversable;

class ComboFieldValue extends AbstractFieldValue implements \IteratorAggregate
{
    /** @var  Collection */
    protected $subfields;

    public function __construct($data, $subfields)
    {
	$newData = [];
	foreach ($data as $k => $v) {
	    $newV = new \stdClass();
	    $newV->fields = [];
	    $v = (array)$v;
	    foreach ($v['fields'] as $fk => $fv) {
		$newV->fields[$fk] = $fv;
	    }
	    $newData[$k] = $newV;
	}
	parent::__construct($newData);
	$this->subfields = $subfields;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        $data = [];

        if ($this->data !== null) {
            foreach ($this->data as $k => $v) {
                $data[$k] = [];

                foreach ($v->fields as $id => $d) {
                    $data[$k][$id] = $d;
                }
            }
        }

        return new \ArrayIterator($data);
    }

    public function getValueForSubField($hash, $fieldId)
    {
	$field = $this->subfields->first(function($i, $f) use ($fieldId) { return $f->getId() == $fieldId; });

	$instance = $this->data[$hash];
	$fieldData = new FieldData();
	if (array_key_exists($fieldId, $instance->fields)) {
	    $fieldData->value = $instance->fields[$fieldId];
	} else {
	    $fieldData->value = $field->getInitialValue();
	}
	$data = $field->parseData($fieldData);
	return $data;
    }
}
