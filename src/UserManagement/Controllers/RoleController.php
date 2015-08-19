<?php

namespace Escape\Argon\UserManagement\Controllers;

use Escape\Argon\Authentication\GrantRepository;
use Escape\Argon\Authentication\RoleRepository;
use Escape\Argon\Core\Controllers\BaseController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Input;
use Lang;
use Redirect;
use View;

class RoleController extends BaseController
{
    /** @var RoleRepository */
    protected $roleRepository;

    /** @var GrantRepository */
    protected $grantRepository;

    public function __construct(Request $request, RoleRepository $roleRepository, GrantRepository $grantRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->grantRepository = $grantRepository;
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        $this->middleware('perm:cms:role:manage');

        parent::__construct($request);
    }

    public function index()
    {
        return View::make('argon::role.roles', ['roles' => $this->roleRepository]);
    }

    public function edit($roleId)
    {
        $role = $this->roleRepository->find($roleId);
        if (!$role) {
            return \Redirect::route('cms:role:manage');
        }

        return View::make('argon::role.edit', ['role' => $role, 'permissions' => app('permissions')]);
    }

    public function update($roleId)
    {
        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $permissions = Input::get('permissions');

        $role = $this->roleRepository->update(Input::all(), $roleId);

        $this->grantRepository->syncGrants($role, $permissions);

        return Redirect::route('cms:role:edit', [$roleId])->with('message', Lang::get('argon-users::role.saved'));
    }

    public function delete($roleId)
    {
        if ($roleId == 1) {
            return Redirect::route('cms:role:manage')->with('error', 'Not allowed');
        }

        $role = $this->roleRepository->find($roleId);

        $role->users()->sync([]);

        $this->grantRepository->deleteAllForRole($role);

        $this->roleRepository->delete($roleId);


        return Redirect::route('cms:role:manage')->with('message', Lang::get('argon-users::role.deleted'));
    }

    public function create()
    {
        return View::make('argon::role.create', ['permissions' => app('permissions')]);
    }

    public function save()
    {
        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $role = $this->roleRepository->create(Input::all());

        $permissions = Input::get('permissions', []);

        $this->grantRepository->syncGrants($role, $permissions);

        return Redirect::route('cms:role:manage')->with('message', Lang::get('argon-users::role.created'));
    }
}