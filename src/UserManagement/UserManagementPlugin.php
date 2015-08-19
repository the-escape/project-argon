<?php

namespace Escape\Argon\UserManagement;

use Escape\Argon\core\Plugins\AbstractPlugin;
use Escape\Argon\Core\Plugins\PluginManager;

class UserManagementPlugin extends AbstractPlugin
{
    protected $name = 'User Management';

    public function register(PluginManager $manager)
    {
        $manager->registerNavLink('Users', route('cms:user:manage'), 'cms:user:manage');
        $manager->registerNavLink('Roles', route('cms:role:manage'), 'cms:role:manage');
    }
}