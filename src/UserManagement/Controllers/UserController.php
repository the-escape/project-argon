<?php

namespace Escape\Argon\UserManagement\Controllers;

use Escape\Argon\Authentication\RoleRepository;
use Escape\Argon\Authentication\UserRepository;
use Escape\Argon\Core\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Input;
use Redirect;
use View;

class UserController extends BaseController
{
    protected $userRepository;

    public function __construct(Request $request, UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        $this->middleware('perm:cms:user:manage', ['except' => 'profile']);

        parent::__construct($request);
    }

    public function index()
    {
        return View::make('argon::user.users', ['users' => $this->userRepository]);
    }

    public function profile()
    {
        return View::make('argon::user.profile');
    }

    public function edit($userId)
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            return \Redirect::route('cms:user:manage');
        }

        $roles = $this->roleRepository->all();

        return View::make('argon::user.edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update($userId)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'email' => 'required'
        ]);

        if (Input::get('password')) {
            $user = $this->userRepository->update(Input::all(), $userId);
        } else {
            $user = $this->userRepository->update(Input::except('password'), $userId);
        }

        $roles = Input::get('roles', []);

        $user->roles()->sync($roles);

        return Redirect::route('cms:user:edit', [$userId])->with('message', Lang::get('argon-users::user.saved'));
    }

    public function delete($userId)
    {
        if ($userId == 1) {
            return Redirect::route('cms:user:manage')->with('error', 'Not allowed');
        }

        $user = $this->userRepository->find($userId);

        $user->roles()->sync([]);

        $this->userRepository->delete($userId);

        return Redirect::route('cms:user:manage')->with('message', Lang::get('argon-users::user.deleted'));
    }

    public function create()
    {
        return View::make('argon::user.create');
    }

    public function save()
    {
        $this->validate($this->request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $this->userRepository->create(Input::all());

        return Redirect::route('cms:user:manage')->with('message', Lang::get('argon-users::user.created'));
    }
}