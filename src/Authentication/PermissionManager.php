<?php

namespace Escape\Argon\Authentication;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class PermissionManager
{
    protected $permissions = [];

    /**
     * @var GateContract
     */
    protected $gate;

    public function __construct(GateContract $gate)
    {
        $this->gate = $gate;
    }

    public function register($name)
    {
        $this->permissions[$name] = true;

        $this->gate->define($name, function (User $user) use ($name) {
            return $user->hasPermission($name);
        });
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
