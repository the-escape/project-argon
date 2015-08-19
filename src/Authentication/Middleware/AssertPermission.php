<?php

namespace Escape\Argon\Authentication\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AssertPermission
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
     * @param  string $perm
     * @return mixed
     */
    public function handle($request, Closure $next, $perm)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                $prefix = trim(config('argon.admin_route_prefix'), '/');
                return redirect()->guest("/{$prefix}/login");
            }
        }

        if (!$request->user()->hasPermission($perm))
        {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}