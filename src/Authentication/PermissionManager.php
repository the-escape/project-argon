<?php

namespace Escape\Argon\Authentication;

class PermissionManager
{
    protected $permissions = [];

    public function register($name)
    {
        $this->permissions[$name] = true;
    }

    public function validate($name)
    {
        return array_key_exists($name, $this->permissions);
    }

    public function getDefinedPermissions()
    {
        return array_keys($this->permissions);
    }
}