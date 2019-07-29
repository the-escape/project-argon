<?php

namespace Escape\Argon\UserManagement\Controllers;

use Escape\Argon\Authentication\RoleRepository;
use Escape\Argon\Authentication\UserRepository;
use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Events\BeforeUserDelete;
use Escape\Argon\Events\UserDelete;
use Escape\Argon\Helpers\Skynet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Input;
use Redirect;
use View;
use Image;

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

    public function index(Request $request)
    {
        $roles = $this->roleRepository->all();

        $perPage = $request->input('perpage', 25);
        $orderBy = $request->input('order', 'id');
        $orderDir = $request->input('dir', 'asc');

        $model = $this->userRepository->model();
        $query = $model::orderBy($orderBy, $orderDir);

        if ($search = $request->input('keywords'))
        {
            $search = trim($search);
            $query = $query->where(function($q) use ($search) {
                $q->where('email', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        if ($role = $request->input('role'))
        {
            $query = $query->whereHas('roles', function($q) use ($role) {
                $q->where('role_id','=',$role);
            });
        }

        if ($request->has('order'))
        {
            $query = $this->getOrder($query, $request);
        }

        $users = $query->paginate($perPage);

        return View::make('argon::user.users', [
            'users' => $users,
            'roles' => $roles,
            'request' => $request
        ]);
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

    public function update($userId, Request $request)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'email' => 'required',
            'profile_picture' => 'mimes:jpeg,bmp,png,gif,jpg'
        ]);

        if ($request->get('password')) {
            $user = $this->userRepository->update($request->all(), $userId);
        } else {
            $user = $this->userRepository->update($request->except('password'), $userId);
        }

        $roles = $request->get('roles', []);

        $user->roles()->sync($roles);

        if ($request->hasFile('profile_picture'))
        {
            $file = $request->file('profile_picture');

            $disk = Storage::disk('media');
            $filePath = sprintf("profile_pictures/%s", $user->id);
            if (!$disk->exists($filePath))
            {
                $disk->makeDirectory($filePath);
            }

            $thumb = Image::make($file)->fit(100, 100);
            $fileName = sprintf("%s/%s%s.%s", $filePath, $user->id, time(), $file->getClientOriginalExtension());
            $disk->put($fileName, $thumb->encode());

            $user->profileValues()->where('key','image')->delete();
            $user->profileValues()->create([
                'key' => 'image',
                'value' => sprintf('/media/%s', $fileName)
            ]);
        }

        return Redirect::route('cms:user:edit', [$userId])->with('message', Lang::get('argon-users::user.saved'));
    }

    public function delete($userId, Request $request, Skynet $skynet)
    {
        if ($userId == 1) {
            return Redirect::route('cms:user:manage')->with('error', 'Not allowed');
        }

        $user = $this->userRepository->find($userId);

        $result = event(new BeforeUserDelete($user, $request));

        if (!empty($result[0]->errors))
        {
            return Redirect::route('cms:user:manage')->with('errors', $result[0]->errors);
        }

        if (isset($result[0]->request))
        {
            $request = $result[0]->request;
        }

        $skynet->rememberUser($user->id);

        $user->roles()->sync([]);

        $user->update([
            'name' => 'Deleted user',
            'email' => $user->id."@deleted.user",
        ]);

        $this->userRepository->delete($userId);

        event(new UserDelete($userId, $request));

        return Redirect::route('cms:user:manage')->with('message', Lang::get('argon-users::user.deleted'));
    }

    public function create()
    {
        return View::make('argon::user.create');
    }

    public function save(Request $request)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'profile_picture' => 'mimes:jpeg,bmp,png,gif,jpg'
        ]);

        $user = $this->userRepository->create($request->all());

        if ($user && $request->hasFile('profile_picture'))
        {
            $file = $request->file('profile_picture');

            $disk = Storage::disk('media');
            $filePath = sprintf("profile_pictures/%s", $user->id);
            if (!$disk->exists($filePath))
            {
                $disk->makeDirectory($filePath);
            }

            $thumb = Image::make($file)->fit(100, 100);
            $fileName = sprintf("%s/%s%s.%s", $filePath, $user->id, time(), $file->getClientOriginalExtension());
            $disk->put($fileName, $thumb->encode());

            $user->profileValues()->create([
                'key' => 'image',
                'value' => sprintf('/media/%s', $fileName)
            ]);
        }

        return Redirect::route('cms:user:edit', [$user->id])->with('message', Lang::get('argon-users::user.created'));
    }

    public function uploadProfileImage()
    {
        // TODO
    }

    private function getOrder($query, Request $request)
    {
        $dir = (in_array($request->input('dir'), ['asc', 'desc'])) ? $request->input('dir') : 'asc';

        switch ($request->input('order'))
        {
            case 'id':
                $query = $query->orderBy('id', $dir);
                break;

            case 'name':
                $query = $query->orderBy('name', $dir);
                break;

            case 'email':
                $query = $query->orderBy('email', $dir);
                break;

            case 'created_at':
                $query = $query->orderBy('created_at', $dir);
                $query = $query->orderBy('id', $dir);
                break;

            default:
                throw new RuntimeException('Unknown order argument!');
        }

        return $query;
    }
}
