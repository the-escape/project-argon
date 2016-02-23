<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\Media\Eloquent\MediaItemRepository;
use \Escape\Argon\Media\Helpers\Media as MediaHelpers;

class ImageFieldValue extends AbstractFieldValue implements \IteratorAggregate, \Countable
{
//    public function __construct($data = null)
//    {
//        if ($data == null) {
//            $d = [];
//        } else {
//            $d = $data;
//        }
//
//        parent::__construct($d);
//    }
    public function __construct($data = null)
    {
        // make data consistently object
        if ($data) {
            if (is_object($data)) {
                $data = (array)$data;
            }
            foreach ($data as $k => &$v) {
                if (is_array($v)) {
                    $v = (object)$v;
                }
            }
        }

        $this->data = $data;
    }

    public function first()
    {
        if (is_array($this->data) && (count($this->data) > 1)) {
            $this->data = array_slice($this->data, 0, 1);
            return $this;
        }

        return $this;
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
                function ($obj) use ($itemRepository) {
                    if ($obj->id) {
                        $media_item = $itemRepository->find($obj->id);
                        $media_item->filesize_formatted = $media_item->getFriendlyFilesize();
                        $media_item->meta = json_decode($media_item->meta);
                        $media_item->data = new \stdClass();
                        $media_item->data->alt = @$obj->alt;
                        return $media_item;
                    }
                    return null;
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
