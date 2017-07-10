<?php

namespace Escape\Argon\Core\Plugins;

use Escape\Argon\Auth\User;

class PluginManager
{
    protected $registeredPlugins = [];

    protected $navLinks = [];

    public function register(AbstractPluginServiceProvider $plugin)
    {
        $this->registeredPlugins[$plugin->getName()] = $plugin;
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
