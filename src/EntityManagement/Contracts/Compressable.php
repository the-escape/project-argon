<?php

namespace Escape\Argon\EntityManagement\Contracts;

interface Compressable
{
    /**
     * Convert the object to flat associative array
     *
     * @return array key => value
     */
    public function compress();
}
