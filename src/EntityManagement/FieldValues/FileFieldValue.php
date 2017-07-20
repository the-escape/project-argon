<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\Media\Eloquent\MediaItemRepository;

class FileFieldValue extends AbstractFieldValue implements \Countable, \Iterator
{
    private $position;

    public function __construct($data = null)
    {
        if ($data == null) {
            $d = [];
        } else {
            $d = $data;
        }

        parent::__construct($d);
        $this->position = 0;
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
        $key = @array_keys($this->data)[$this->position];

        $id = array_key_exists($key, $this->data) ? $this->data[$key] : null;

        if ($id) {
            /** @var MediaItemRepository $itemRepository */
            $itemRepository = app()->make(MediaItemRepository::class);
            $media_item = $itemRepository->findWhere(['id' => $id])->first();
            if (!$media_item) {
                throw new \RuntimeException("Media item not found. Likely soft deleted. Requsted id: '$id'.");
            }
            $media_item->filesize_formatted = $media_item->getFriendlyFilesize();
            $media_item->meta = json_decode($media_item->meta);
            $media_item->data = new \stdClass();
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

    public function getUrl()
    {
        if ($this->current()) {
            return $this->current()->getUrl();
        }

        return null;
    }

    public function isEmpty()
    {
        if ($this->current()) {
            return false;
        }

        return true;
    }

    public function __toString()
    {
        if ($this->isEmpty())
        {
            return "";
        }

        $media_items = [];

        foreach ($this->data as $key => $id)
        {
            if ($id) {
                /** @var MediaItemRepository $itemRepository */
                $itemRepository = app()->make(MediaItemRepository::class);
                $media_item = $itemRepository->findWhere(['id' => $id])->first();
                if (!$media_item) {
                    throw new \RuntimeException("Media item not found. Likely soft deleted. Requsted id: '$id'.");
                }
                $media_item->filesize_formatted = $media_item->getFriendlyFilesize();
                $media_item->meta = json_decode($media_item->meta);
                $media_item->data = new \stdClass();
                $media_items[] = $media_item;
            }
        }

        return json_encode($media_items);

    }
}
