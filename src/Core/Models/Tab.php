<?php

namespace Escape\Argon\Core\Models;

class Tab
{
    const CLASS_ACTIVE = 'active';

    private $label;
    private $url;
    private $active;

    public function __construct($label, $url, $active = null)
    {
        $this->label = $label;
        $this->url = $url;
        $this->active = $active;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function isActive()
    {
        if ($this->active === true) {
            return self::CLASS_ACTIVE;
        }

        if ($this->active === false || is_null($this->url)) {
            return '';
        }

        $uri = request()->getUri();

        if ($this->url === $uri) {
            return self::CLASS_ACTIVE;
        }

        if (strstr($this->url, $uri, true) === '') {
            return self::CLASS_ACTIVE;
        }

        return '';
    }
}
