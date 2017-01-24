<?php

namespace Escape\Argon\Core\Models;

use Illuminate\Http\Request;

class Tab
{
    const CLASS_ACTIVE = 'active';

    private $label;
    private $url;
    private $forceActive;

    public function __construct($label, $url, $forceActive = false)
    {
        $this->label = $label;
        $this->url = $url;
        $this->forceActive = $forceActive;
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
        if ($this->forceActive) {
            return self::CLASS_ACTIVE;
        }

        if (is_null($this->url)) {
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
