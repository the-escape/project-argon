<?php

namespace Escape\Argon\Auth;

use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;

class GrantRepository extends BaseRepository
{
    public function model()
    {
        return PermissionGrant::class;
    }

    /**
     * @param Role $role
     * @return mixed
     */
    public function getForRole(Role $role)
    {
        return $this->findByField('role_id', $role->id);
    }

    public function syncGrants(Role $role, $permissions)
    {
        /** @var Collection $grants */
        $grants = $this->getForRole($role);

        $keep = $grants->filter(function ($grant) use ($permissions) {
            return in_array($grant->permission->name, $permissions);
        });

        $remove = $grants->reject(function ($grant) use ($permissions) {
            return in_array($grant->permission->name, $permissions);
        });

        $add = array_filter($permissions, function ($permission) use ($keep) {
            foreach ($keep as $grant) {
                if ($grant->permission->name == $permission) {
                    return false;
                }
            }
            return true;
        });

        foreach ($remove as $grantToRemove) {
            $this->delete($grantToRemove->id);
        }

        foreach ($add as $permission) {
            /** @var PermissionGrant $model */
            $model = $this->makeModel();
            $model->permission = $permission;
            $model->role = $role;
            $model->save();
        }
    }

    public function deleteAllForRole($role)
    {
        $this->getForRole($role)->each(function (PermissionGrant $grant) {
            $grant->delete();
        });
    }
}
