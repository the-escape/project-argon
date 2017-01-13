<?php

namespace Escape\Argon\Authentication\Http\Controllers;

use Escape\Argon\Authentication\Http\Requests\ResetPasswordRequest;
use Escape\Argon\Authentication\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function index($token = null)
    {
        if (is_null($token)) {
            return redirect()
                ->to('/admin/login')
                ->withErrors(['auth' => trans('argon.auth::reset-password.invalid')]);
        }

        return view('argon.auth::pages.reset-password',
            compact('token'));
    }

    public function create(ResetPasswordRequest $request)
    {
        $response = Password::reset($this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        if ($response === Password::PASSWORD_RESET) {
            return redirect()
                ->to('/admin')
                ->with('success', trans('argon.auth::reset-password.success'));
        }

        return redirect()
            ->back()
            ->withInput($request->only(['only']))
            ->withErrors([
                'invalid' => trans('argon.auth::reset-password.invalid')
            ]);
    }

    protected function resetPassword(User $user, $password)
    {
        $user->forceFill([
           'password' => $password,
            'remember_token' => Str::random(60),
        ])->save();

        auth()->login($user);
    }

    protected function credentials(ResetPasswordRequest $request)
    {
        return $request->only(['email', 'password', 'password_confirmation', 'token']);
    }
}
