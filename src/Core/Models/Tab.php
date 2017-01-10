<?php

namespace Escape\Argon\Core\Models;

class Tab
{
    private $label;
    private $url;

    public function __construct($label, $url)
    {
        $this->label = $label;
        $this->url = $url;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getUrl()
    {
        return $this->url;
    }
}
