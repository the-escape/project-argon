<?php

namespace Escape\Argon\Table\Models;

class TableColumn
{
    private $name;
    private $label;
    private $width;

    public function __construct($name, $label, $width)
    {
        $this->name = $name;
        $this->label = $label;
        $this->width = $width;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getWidth()
    {
        return $this->width;
    }
}
