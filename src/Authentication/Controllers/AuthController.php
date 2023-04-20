<?php

namespace Escape\Argon\Authentication\Controllers;

use Escape\Argon\Authentication\User;
use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Events\Lockout;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    protected $loginPath = '/admin/login';

    private $lockoutTime = 30;

    private $username = 'email';

    protected $userRepository;

    protected $activationService;

    protected $maxLoginAttempts = 3;

    protected $attempts;

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

    use AuthenticatesAndRegistersUsers {
//        postLogin as traitPostLogin;
    }
    use ThrottlesLogins;

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
            'password' => 'required|confirmed|min:6',
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
    public function getLogin()
    {
        return view('argon::auth.login');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::get('argon-auth::auth.failed');
    }

    protected function authenticated(Request $request, User $user)
    {
        $localeRepository = app(LocaleRepository::class);

        $request->session()->put('locale', $localeRepository->primary()->id);
        return redirect()->intended('/admin');
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $data = $request->only([
            'email',
            'password',
        ]);

        $attempts = session()->get('login_attempts_' . $this->username, 0);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        $credentials = $this->getCredentials($request);
        if (Auth::attempt($credentials, $request->has('remember'))) {
            session()->set('login_attempts_' . $this->username, 0);
            $this->clearLoginAttempts($request);
            $this->logoutOtherSessions();
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // How many attempts have we made
        if ($attempts >= ($this->maxLoginAttempts * 4)) {
            // if we've done 12+ then quadruple lockout time
            $this->lockoutTime = $this->lockoutTime * 4;
        } elseif ($attempts >= ($this->maxLoginAttempts * 2)) {
            // If we've done 6 then double lockout time
            $this->lockoutTime = ($this->lockoutTime * 2);
        }

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {

            $attempts++;
            session()->set('login_attempts_' . $this->username, $attempts);
            $this->incrementLoginAttempts($request);

            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if (Auth::attempt($data)) {
            session()->set('login_attempts_' . $this->username, 0);
            $this->clearLoginAttempts($request);
            $this->logoutOtherSessions();

            return redirect()
                ->route('dashboard')
            ;
        } else {
            if ($this->secondsRemainingOnLockout($request) <= 0) {
                $attempts++;
                session()->set('login_attempts_' . $this->username, $attempts);
                $this->incrementLoginAttempts($request);
            }
        }

        return redirect()
            ->route('admin:login')
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage() . ' - This is attempt number ' . $attempts
            ])
        ;
    }

    /**
     * Get the lockout seconds.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    protected function secondsRemainingOnLockout(Request $request)
    {
        return app(RateLimiter::class)->availableIn(
            $this->getThrottleKey($request)
        );
    }

    /**
     * Fire an event when a lockout occurs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function fireLockoutEvent(Request $request)
    {
        event(new Lockout($request));
    }    
    
    /**
    * Determine how many retries are left for the user.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return int
    */
   protected function retriesLeft(Request $request)
   {
       return app(RateLimiter::class)->retriesLeft(
           $this->getThrottleKey($request),
           $this->maxLoginAttempts()
       );
   }
    
   public function clearCurrentSession($key)
   {
       session()->forget($key);
       Cache::forget($key);
   }

   /**
    * Get user's current session id. Save it, to be compared on each request with a middleware
    *
    * @return void
    */
   public function logoutOtherSessions()
   {
       $sessionId = session()->getId();
       $userId = Auth::id();
       $key = 'latest_session_' . $userId;

       $this->clearCurrentSession($key);

       session()->set($key, $sessionId);
       $expiresAt = (new \DateTime())->modify('+1 day');
       Cache::put($key, $sessionId, $expiresAt);
   }    
   
   /**
   * Redirect the user after determining they are locked out.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  protected function sendLockoutResponse(Request $request)
  {
      $seconds = app(RateLimiter::class)->availableIn(
          $this->getThrottleKey($request)
      );

      $attempts = session()->get('login_attempts_' . $this->username, 0);

      return redirect()->back()
          ->withInput($request->only($this->loginUsername(), 'remember'))
          ->withErrors([
              $this->loginUsername() => $this->getLockoutErrorMessage($seconds) . ' - This is attempt number ' . $attempts
          ]);
  }

}
