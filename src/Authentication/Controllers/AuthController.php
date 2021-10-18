<?php

namespace Escape\Argon\Authentication\Controllers;

use Escape\Argon\Authentication\User;
use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Illuminate\Http\Request;
use Lang;
use Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends BaseController
{
    protected $loginPath = '/admin/login';

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers;

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('argon::auth.login');
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get('argon-auth::auth.failed'),
            ]);
    }

    protected function authenticated(Request $request, User $user)
    {
        $localeRepository = app(LocaleRepository::class);

        $request->session()->put('locale', $localeRepository->primary()->id);
        return redirect()->intended('/admin');
    }
}
