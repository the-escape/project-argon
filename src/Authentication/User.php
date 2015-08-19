<?php

namespace Escape\Argon\Authentication;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package Escape\Argon
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Collection $roles
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasPermission($perm)
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($perm)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($roleName)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $roleName) {
                return true;
            }
        }

        return false;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
