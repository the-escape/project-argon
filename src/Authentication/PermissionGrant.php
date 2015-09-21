<?php

namespace Escape\Argon\Authentication;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PermissionGrant
 * @package Escape\Argon
 *
 * @property Role $role
 * @property Permission $permission;
 */
class PermissionGrant extends Model
{
    protected $table = 'permission_role';

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getPermissionAttribute($value)
    {
        return Permission::find($value);
    }

    public function setPermissionAttribute($value)
    {
        if ($value instanceof Permission) {
            $value = $value->name;
        }

        $this->attributes['permission'] = $value;
    }

    public function setRoleAttribute($role)
    {
        $this->attributes['role_id'] = $role->id;
    }
}
