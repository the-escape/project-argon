<?php

namespace Escape\Argon\Core\Plugins;

use Escape\Argon\Authentication\User;

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

    public function registerNavLink($name, $url, $access = '', $icon = 'pages', $group = 'default')
    {

        if ($url === route('cms:dashboard'))
        {
            $active = preg_match('/admin$/', request()->url()) === 1;
        }
        else
        {
            $active = strpos(request()->url(), $url) !== false;
        }


        $this->navLinks[$group][$name] = (object)[
            'name' => $name,
            'url' => $url,
            'access' => $access,
            'icon' => $icon,
            'group' => $group,
            'active' => $active
        ];
    }
}
