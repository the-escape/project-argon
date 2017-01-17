<?php

namespace Escape\Argon\User\Http\Controllers;

use Escape\Argon\Authentication\UserRepository;
use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\Table\Models\Table;
use Escape\Argon\Table\Models\TableRow;
use Escape\Argon\User\Http\Requests\UserStoreRequest;
use Kamaln7\Toastr\Facades\Toastr;

class UserController extends BaseController
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        parent::__construct();
    }

    function setMiddleware()
    {
        return [
            'perm:cms:login',
            'perm:cms:user:manage',
        ];
    }

    public function setTabs()
    {
        return [
            new Tab('ALL USERS', action('\Escape\Argon\User\Http\Controllers\UserController@index')),
            new Tab('NEW USER', action('\Escape\Argon\User\Http\Controllers\UserController@create')),
        ];
    }

    public function index()
    {
        // Get all users.
        $users = $this->userRepository->all();

        $table = new Table();

        // Setup the table columns.
        $table->addColumn('name', 'NAME', 20);
        $table->addColumn('role', 'ROLE', 20);

        // Loop through all users to setup the data array.
        foreach ($users as $user) {

            $row = new TableRow($user->id, [
                'name' => '1234',
                'role' => $user->roles->implode('name', ', ')
            ]);

            // Create all of the rows actions.
            $row->addAction(TableRow::TABLE_ACTION_DELETE,
                action('\Escape\Argon\User\Http\Controllers\RoleController@edit', $user->id));
            $row->addAction(TableRow::TABLE_ACTION_BUTTON,
                action('\Escape\Argon\User\Http\Controllers\RoleController@edit', $user->id),
                'EDIT USER');

            $table->addRow($row);
        }

        // Render the table using our custom columns and data.
        return view('argon::partials.table')->with([
            'name' => 'Users',
            'table' => $table,
        ]);
    }

    public function create()
    {
        return view('argon.user::pages.create')->with([
            'name' => 'Users',
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        // Create a new user based on the request.
        //$this->userRepository->create($request->only(['name', 'email', 'password']));

        Toastr::success('User successfully created.', 'SUCCESS');

        // Redirect back to the table view.
        return redirect()->route('cms:user:manage');
    }
}
