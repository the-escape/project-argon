<?php

namespace Escape\Argon\EntityManagement\FieldValues;

class MenuFieldValue extends AbstractFieldValue implements \Iterator
{
    protected $position;

    public function __construct($data = [])
    {
        if (is_object($data)) {
            $data = toArray($data);
        }

        if (!is_array($data)) {
            if ($data != null) {
                $data = [(int)$data];
            } else {
                $data = [];
            }
        }

//        dd($data);

        foreach ($data as $k => $v) {
            if (!$v) {
                unset($data[$k]);
            }
        }

        $data = array_values($data);

        parent::__construct($data);
        $this->position = 0;
    }

    public function getSlugs()
    {
        return $this->data;
    }

    public function containsSlug($slug)
    {
        return in_array($slug, $this->data);
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        $menuSlug = @$this->data[$this->position];
        if (is_null($menuSlug))
        {
            return null;
        }

        $menu = menuCache($menuSlug);
        if (is_null($menu))
        {
            return null;
        }

        return $menu;
    }

    public function first()
    {
        $this->rewind();
        return $this->current();
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

    public function compress()
    {
        $slugs = $this->data;
        $values = [];

        if (!$slugs)
        {
            return $values;
        }

        foreach($slugs as $slug)
        {
            $menu = menuCache($slug);

            if(!empty($menu) && !empty($menu->menu))
            {
                $menusData = [];
                foreach($menu->menu as $m)
                {
                    $menusData[] = $m->data;
                }
                $values[$slug] = $menusData;
            }
        }

        return $values;
    }
}
