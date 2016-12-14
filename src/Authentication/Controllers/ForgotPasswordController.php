<?php

namespace Escape\Argon\Authentication\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends BaseController
{
    public function index()
    {
        return view('argon::auth.forgot-password');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $response = Password::sendResetLink($request->only('email'));

        if ($response === Password::RESET_LINK_SENT) {
            return back()
                ->with('success', 'We have emailed your password reset link.');
        }

        return back()->withErrors([
            'email' => $response,
        ]);
    }
}
