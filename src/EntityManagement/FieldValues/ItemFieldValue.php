<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\Frontend\Page;

class ItemFieldValue extends AbstractFieldValue implements \Iterator
{
    protected $position;

    public function __construct($data = [])
    {
        if (is_object($data)) {
            $data = toArray($data);
        }

        if (is_array($data)) {
            $data = array_map(
                function ($i) {
                    return (int)$i;
                },
                $data
            );
        } elseif ($data != null) {
            $data = [(int)$data];
        } else {
            $data = [];
        }
        parent::__construct($data);
        $this->position = 0;
    }

    public function getIds()
    {
        return $this->data;
    }

    public function containsId($id)
    {
        return in_array($id, $this->data);
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        $id = $this->data[$this->position];
        /** @var EntityRepository $repository */
        $repository = app()->make(EntityRepository::class);

        $entity = $repository->find($id);

        return new Page($entity);
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return array_key_exists($this->position, $this->data);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }
}
