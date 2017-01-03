<?php

namespace Escape\Argon\Authentication\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AssertRole
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                $prefix = trim(config('argon.admin_route_prefix'), '/');
                return redirect()->guest("/{$prefix}/login");
            }
        }

        if (!$request->user()->hasRole($role)) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
