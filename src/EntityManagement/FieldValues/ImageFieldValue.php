<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Eloquent\EntityCache;
use Escape\Argon\EntityManagement\Eloquent\FieldData;
use Escape\Argon\Media\Eloquent\MediaItem;
use Escape\Argon\Media\Eloquent\MediaItemRepository;
use \Escape\Argon\Media\Helpers\Media as MediaHelpers;
use RuntimeException;
use stdClass;

class ImageFieldValue extends AbstractFieldValue implements \Iterator, \Countable
{
    private $position;

    public function __construct($data = null)
    {
        // format data consistently
        if (!$data) {
            $data = [];
        }

        if (is_object($data)) {
            $data = toArray($data);
        }

        foreach ($data as $k => &$v) {
            if (is_array($v)) {
                $v = (object)$v;
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
        $key = @array_keys($this->data)[$this->position];

        $obj = @$this->data[$key];

        if (!is_object($obj))
        {
            return null;
        }

        if (property_exists($obj, 'id') && property_exists($obj, 'url') && property_exists($obj, 'alt'))
        {
            return new CacheMediaItemValue([
                'id' => $obj->id,
                'url' => $obj->url,
                'alt' => $obj->alt,
            ]);
        }

        $key = @array_keys($this->data)[$this->position];

        $obj = @$this->data[$key];

        if (@$obj->id)
        {
            $itemRepository = app()->make(MediaItemRepository::class);
            $media_item = $itemRepository->findWhere(['id' => $obj->id])->first();

            if (!$media_item)
            {
                throw new RuntimeException("Media item not found. Likely soft deleted. Requsted id: '$obj->id'.");
            }

            $media_item->filesize_formatted = $media_item->getFriendlyFilesize();
            $media_item->meta = json_decode($media_item->meta);
            $media_item->data = new stdClass();
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

    /**
     * @deprecated
     * Legacy method not recommended. Will be removed at some point.
     * Use getUrl() method instead to keep things in sync with Escape\Argon\Media\Eloquent\MediaItem object instance.
     * @param array $args - see Escape\Argon\Media\Eloquent\MediaItem::getUrl() for more info.
     * @return null|string
     */
    public function getImageSrc(array $args=[])
    {
        return $this->getUrl($args);
    }

    /**
     * Generates URL to asset.
     * Accepts args formatted as query string key=value pairs separated by & symbol.
     * @param array $args - see Escape\Argon\Media\Eloquent\MediaItem::getUrl() for more info.
     * @return string $url
     */
    public function getUrl(array $args=[])
    {
        if ($this->current()) {
            return $this->current()->getUrl($args);
        }

        return null;
    }

    public function getWidth()
    {
        if ($this->current()) {
            return $this->current()->getWidth();
        }

        return null;
    }

    public function getHeight()
    {
        if ($this->current()) {
            return $this->current()->getHeight();
        }

        return null;
    }

    /**
     * @deprecated
     * Legacy method not recommended. Will be removed at some point.
     * Use getAlt() method instead to keep things in sync with Escape\Argon\Media\Eloquent\MediaItem object instance.
     * @param sring $default - string to use if no saved value. Dafaults to empty string.
     * @return null|string
     */
    public function getImageAlt($default='')
    {
        return $this->getAlt($default);
    }

    public function getAlt($default='')
    {
        if ($this->current()) {
            return $this->current()->getAlt($default);
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

        foreach ($this->data as $key => $obj)
        {
            if (@$obj->id) {
                /** @var MediaItemRepository $itemRepository */
                $itemRepository = app()->make(MediaItemRepository::class);
                $media_item = $itemRepository->findWhere(['id' => $obj->id])->first();
                if (!$media_item) {
                    throw new \RuntimeException("Media item not found. Likely soft deleted. Requsted id: '$obj->id'.");
                }
                $media_item->filesize_formatted = $media_item->getFriendlyFilesize();
                $media_item->meta = json_decode($media_item->meta);
                $media_item->data = new \stdClass();
                $media_item->data->alt = @$obj->alt;
                $media_items[] = $media_item;
            }
        }

        return json_encode($media_items);
    }

    // TODO: trait
    public function toJson($options = 0)
    {
        $values = [];
        $ids = [];

        // Check if value $value retrieved from cache
        foreach ($this->data as $key => $value)
        {
            if (is_object($value))
            {
                if (property_exists($value, 'id') && property_exists($value, 'url') && property_exists($value, 'alt'))
                {
                    $values[] = $value;
                }
            }
        }

        if ($values)
        {
            return json_encode($values, $options);
        }

        foreach ($this->data as $key => $value)
        {

            $ids[] = $value->id;
        }

        $mediaItems = MediaItem::withTrashed()->whereIn('id', $ids)->get();

        foreach ($mediaItems as $mediaItem)
        {
            $item = new stdClass();
            $item->id = $mediaItem->getId();
            $item->url = $mediaItem->getUrl();
            $item->alt = $mediaItem->getAlt();

            $values[] = $item;
        }

        return json_encode($values, $options);
    }
}
