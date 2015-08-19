<?php

namespace Escape\Argon\core\Plugins;

use Escape\Argon\Authentication\User;
use Escape\Argon\Core\Plugins\PluginManager;

abstract class AbstractPlugin
{
    protected $name = '';

    abstract public function register(PluginManager $manager);

    public function getName()
    {
        if ($this->name == '') {
            throw new \Exception('Plugin name has not been set.');
        }

        return $this->name;
    }
}