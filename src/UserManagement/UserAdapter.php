<?php

namespace Escape\Argon\UserManagement;

use Illuminate\Http\Request;
use Escape\Argon\Authentication\User;
use Escape\Argon\Authentication\Role;
use Escape\Argon\Core\Plugins\PluginManager;

use Escape\Argon\Core\Controllers\BaseController;

class UserAdapter extends BaseController
{

    protected $userRepository;
    protected $roleRepository;
    protected $pluginManager;
    protected $user;

    /**
     * UserAdapter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        //Models
        $this->userRepository = User::all();
        $this->roleRepository = Role::all();
    }


    /**
     * Get menu links
     *
     * @return array
     */
    public function getNavLinksForUser()
    {
        $navLinks = $this->pluginManager->getNavLinksForUser($this->currentUser);
        $i = 0;
        foreach ($navLinks as $link) {
            foreach ($link as $item) {


                $arr[] = [
                    'id' => $i,
                    'name' => $item->name,
                    'handle' => substr($item->url, (strrpos($item->url, "/")) + 1),
                    'access' => $item->access,
                    'alert' => null
                ];
                ++$i;
            }
        }

        return $arr;
    }

    /**
     * @return array
     */
    public function getDb()
    {
        return [
            'users' => $this->userRepository,
            'userroles' => $this->roleRepository,
            'nav' => $this->getNavLinksForUser(),
        ];

    }

    /**
     * Display required data in json format
     *
     * @param null $param
     */
    public function getData($param = null)
    {

        switch ($param) {
            case 'users':
                $data = $this->userRepository;
                break;
            case 'userRoles':
                $data = $this->roleRepository;
                break;
            case 'nav':
                $data = $this->getNavLinksForUser();
                break;
            case 'db':
                $data = $this->getDb();
                break;
        }

        header('Content-Type: application/json');
        echo nl2br(json_encode($data, JSON_PRETTY_PRINT));
    }

    public function create()
    {

        $this->validate($this->request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $this->userRepository->create(Input::all());
    }


}
