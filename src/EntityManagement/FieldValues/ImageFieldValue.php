<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\Media\Eloquent\MediaItem;
use Escape\Argon\Media\Eloquent\MediaItemRepository;
use \Escape\Argon\Media\Helpers\Media as MediaHelpers;

class ImageFieldValue extends AbstractFieldValue implements \Iterator, \Countable
{
    private $position;

    public function __construct($data = null)
    {
        // make data consistently object
        if ($data) {
            if (is_object($data)) {
                $data = toArray($data);
            }
            foreach ($data as $k => &$v) {
                if (is_array($v)) {
                    $v = (object)$v;
                }
            }
        }

        parent::__construct($data);
        $this->position = 0;
    }

    public function first()
    {
        if (is_array($this->data) && (count($this->data) > 1)) {
            $this->data = array_slice($this->data, 0, 1);
            return $this;
        }

        return $this;
    }

    public function count()
    {
        return count($this->data);
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return MediaItem
     * @since 5.0.0
     */
    public function current()
    {
        $key = array_keys($this->data)[$this->position];

        $obj = $this->data[$key];

        if ($obj->id) {
            /** @var MediaItemRepository $itemRepository */
            $itemRepository = app()->make(MediaItemRepository::class);
            $media_item = $itemRepository->find($obj->id);
            $media_item->filesize_formatted = $media_item->getFriendlyFilesize();
            $media_item->meta = json_decode($media_item->meta);
            $media_item->data = new \stdClass();
            $media_item->data->alt = @$obj->alt;
            return $media_item;
        }
        return null;
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
        return array_key_exists($this->position, array_keys($this->data));
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

    public function getImageSrc()
    {
        return $this->current()->getUrl();
    }

}
