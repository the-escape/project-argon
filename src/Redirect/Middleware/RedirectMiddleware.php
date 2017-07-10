<?php

namespace Escape\Argon\Redirect\Middleware;

use Closure;
use Escape\Argon\Redirect\Eloquent\RedirectRepository;

class RedirectMiddleware
{
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
