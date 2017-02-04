<?php

namespace Escape\Argon\Auth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 * @package Escape\Argon
 *
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Collection $permissions
 * @property Collection $users
 * @property Collection $grants
 */
class Role extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function grants()
    {
        return $this->hasMany(PermissionGrant::class);
    }

    public function permissions()
    {
        return $this->grants->map(function ($grant) {
            return $grant->permission;
        });
    }

    public function __get($key)
    {
        if ($key == 'permissions') {
            return $this->permissions();
        } else {
            return parent::__get($key);
        }
    }

    public function hasPermission($permissionName)
    {
        foreach ($this->grants as $grant) {
            if ($grant->permission->name == $permissionName) {
                return true;
            }
        }

        return false;
    }

    public function grant(Permission $perm)
    {
        $grant = new PermissionGrant();
        $grant->permission = $perm;
        $grant->role = $this;
        $grant->save();
    }
}
