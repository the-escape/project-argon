<?php

namespace Escape\Argon\Core\Plugins;

use Escape\Argon\Authentication\User;
use Escape\Argon\core\Plugins\AbstractPlugin;

class PluginManager
{
    protected $registeredPlugins = [];

    protected $navLinks = [];

    public function register(AbstractPlugin $plugin)
    {
        $this->registeredPlugins[$plugin->getName()] = $plugin;
        $plugin->register($this);
    }

    public function getPlugins()
    {
        return $this->registeredPlugins;
    }

    public function getNavLinksForUser(User $user)
    {
        $filteredLinks = [];

        foreach ($this->navLinks as $group => $contents) {
            foreach ($contents as $name => $details) {
                $filteredLinks[$group][$name] = $details;
            }
        }

        return $filteredLinks;
    }

    public function registerNavLink($name, $url, $access = '', $group = 'default')
    {
        $this->navLinks[$group][$name] = (object)[
            'name' => $name,
            'url' => $url,
            'access' => $access,
            'group' => $group
        ];
    }
}