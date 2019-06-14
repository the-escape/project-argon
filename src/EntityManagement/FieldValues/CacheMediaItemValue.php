<?php

namespace Escape\Argon\EntityManagement\FieldValues;

use Escape\Argon\EntityManagement\Contracts\Compressable;
use Escape\Argon\Media\Contracts\ImageInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use RuntimeException;
use stdClass;

class CacheMediaItemValue implements Compressable, Arrayable, Jsonable, ImageInterface
{
    protected $id;
    protected $url;
    protected $alt;
    protected $path;
    protected $dimensions;
//    protected $width;
//    protected $height;

    public function __construct(array $values=[])
    {
        foreach ($values as $key => $value)
        {
            if (!property_exists($this, $key))
            {
                continue;
            }

            $this->$key = $value;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUrl(array $args = [], $option = '')
    {
        $url = $this->url;
        $queryStringPos = strpos($url, '?');
        $queryString = substr($url, $queryStringPos);
        $url = substr($url, 0, $queryStringPos);

        if (!empty($args))
        {
            // injecting option to before the file extension
            if (!empty($args['option']))
            {
                $urlArray = explode('.', $url);
                $tmpExtHolder = array_pop($urlArray);
                array_push($urlArray, $args['option'], $tmpExtHolder);
                $tmpUrl = implode('.', $urlArray);

                if(file_exists(public_path($tmpUrl)))
                {
                    $url = $tmpUrl;
                }
            }
        }

        // appending cache buster back if not explicitly set not to do so
        if (!isset($args['updatedAt']) || !in_array($args['updatedAt'], [false, 0, 'false', '0']))
        {
            $url = sprintf('%s?%s', $url, $queryString);
        }

        return $url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

//    public function getWidth()
//    {
//        return $this->width;
//    }
//
//    public function setWidth($width)
//    {
//        $this->width = $width;
//    }
//
//    public function getHeight()
//    {
//        return $this->height;
//    }
//
//    public function setHeight($height)
//    {
//        $this->height = $height;
//    }

    public function getAlt($default="")
    {
        return ($this->alt != "") ? $this->alt : $default;
    }

    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    public function __call($name, $arguments)
    {
        $debug = config('app.debug');

        if ($debug === true)
        {
            throw new RuntimeException("Class '".__CLASS__. "' doesn't have a method '$name'.");
        }

        // Perhaps better to silence the errors here...
        return "";
    }

    public function compress()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return toArray($this);
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function getUnoptimized()
    {
        return $this->getCustomOption('original');
    }

    public function getThumb()
    {
        return $this->getCustomOption('thumb');
    }

    public function getCustomOption($option = '')
    {
        return $this->getUrl(compact('option'));
    }

    public function getWidth()
    {
        return $this->getDimensions()->width;
    }

    public function getHeight()
    {
        return $this->getDimensions()->height;
    }

    public function getPath()
    {
        if (!empty($this->path))
        {
            return $this->path;
        }

        $queryStringPos = strpos($this->url, '?');

        return public_path(substr($this->url, 0, $queryStringPos));
    }

    public function getDimensions()
    {
        if (!empty($this->dimensions))
        {
            return $this->dimensions;
        }

        $dimensions = new stdClass();

        if (!empty($this->width) && !empty($this->height))
        {
            $dimensions->width = $this->width;
            $dimensions->height = $this->height;
        }
        else
        {
            list($width, $height) = @getimagesize($this->getPath());
            $dimensions->width = @$width;
            $dimensions->height = @$height;
        }

        return $dimensions;
    }
}
