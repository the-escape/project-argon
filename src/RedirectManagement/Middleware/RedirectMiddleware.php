<?php

namespace Escape\Argon\RedirectManagement\Middleware;

use Closure;
use Escape\Argon\RedirectManagement\Eloquent\RedirectRepository;

class RedirectMiddleware
{

    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $redirectRepository = app()->make(RedirectRepository::class);
        $redirects = $redirectRepository->all();

        foreach ($redirects as $redirect)
        {
            if ($redirect->from == $request->getPathInfo())
            {
                return redirect($redirect->to, 301);
            }
        }

        return $next($request);
    }
}
