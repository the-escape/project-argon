<?php

namespace Escape\Argon\Authentication\Http\Controllers;

use Escape\Argon\Authentication\Http\Requests\ForgotPasswordRequest;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Display the forgotten password view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('argon.auth::pages.forgot-password');
    }

    /**
     * Attempt to create a password reset request.
     *
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(ForgotPasswordRequest $request)
    {
        // Overwrite the forgotten password email view,
        // This is a nasty hack which isn't needed above Laravel 5.1.
        config([
            'auth.password.email' => 'argon.auth::emails.forgot-password',
        ]);

        // Request a password reset using the email supplied.
        $response = Password::sendResetLink($request->only(['email']));

        // See if the user exists.
        if ($response === Password::RESET_LINK_SENT) {
            return redirect()
                ->to('/admin/login')
                ->with('success', trans('argon.auth::forgot-password.success'));
        }

        // Return if no user is found.
        return back()->withErrors([
            'email' => trans('argon.auth::forgot-password.failed'),
        ]);
    }
}
