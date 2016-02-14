<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\Media\Eloquent\MediaItemRepository;

class FileFieldValue extends AbstractFieldValue implements \IteratorAggregate, \Countable
{
    public function __construct($data = null)
    {
        if ($data == null) {
            $d = [];
        } else {
            $d = $data;
        }

        parent::__construct($d);
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
        /** @var MediaItemRepository $itemRepository */
        $itemRepository = app()->make(MediaItemRepository::class);
        if (is_array($this->data)) {
            $data = array_map(
                function ($id) use ($itemRepository) {
                    return $itemRepository->find($id);
                },
                $this->data
            );
        } else {
            $data = [];
        }
        return new \ArrayIterator($data);
    }

    public function count()
    {
        return count($this->data);
    }
}
