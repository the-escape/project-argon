<?php

namespace Escape\Argon\UserManagement;

use Escape\Argon\Authentication\User;

use Escape\Argon\Core\Controllers\BaseController;

class UserAdapter extends BaseController {

    protected $userRepository;

    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('perm:cms:login');
        //parent::__construct();

        $this->userRepository = User::all();
    }

    public function getAll() {

        return $this->userRepository->toJson();
    }

    public function create() {

        $this->validate($this->request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $this->userRepository->create(Input::all());
    }
}
