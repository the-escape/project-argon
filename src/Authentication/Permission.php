<?php

namespace Escape\Argon\Authentication;

use Escape\Argon\Authentication\Exceptions\PermissionNotDefinedException;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Permission
 * @package Escape\Argon
 *
 * @property string $name
 * @property Collection $roles
 */
class Permission
{
    /** @var Collection */
    protected $grants;
    /** @var string */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public static function find($name)
    {
        /** @var PermissionManager $manager */
        $manager = app('permissions');

        if (!$manager->validate($name)) {
            throw new PermissionNotDefinedException();
        }

        $grants = PermissionGrant::where('permission', $name)->get();

        return new static($grants, $name);
    }

    public function __construct($grants, $name)
    {
        $this->grants = $grants;
        $this->name = $name;
    }

    public function __get($field)
    {
        switch ($field) {
            case 'roles':
                return $this->getRoles();
                break;
            case 'name':
                return $this->getName();
                break;
            default:
                throw new \Exception('Invalid Property');
        }
    }

    /**
     * @return Collection
     */
    public function getRoles()
    {
        return $this->grants->map(function ($grant) {
            return $grant->role;
        });
    }
}