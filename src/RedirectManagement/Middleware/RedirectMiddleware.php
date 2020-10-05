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
     * Filter an incoming request against list of redirects.
     * NOTE: You can pass multiple exclude parameters as a comma-separated list
     * NOTE: You can exclude parameter(s) can end with * - wildcard.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $exclude - parameters as a comma-separated list - avoid whitespace!
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $exclude = null)
    {
        $REQUEST_URI = filter_input(INPUT_SERVER, 'REQUEST_URI');

        if (is_null($REQUEST_URI)) {
            return $next($request);
        }

        $path = parse_url($REQUEST_URI, PHP_URL_PATH);

        $excludes = [];

        if (!is_null($exclude)) {
            $excludes = array_filter(explode(',', $exclude), 'strlen');
        }

        foreach ($excludes as $exclude) {
            if ($path == $exclude) {
                return $next($request);
            }

            $last = $exclude[strlen($exclude) - 1];

            if ('*' == $last) {
                $exclude = rtrim($exclude, '*');
                $strpos = strpos($path, $exclude);

                if (0 === $strpos) {
                    return $next($request);
                }
            }
        }

        $redirectRepository = app()->make(RedirectRepository::class);
        $redirects = $redirectRepository->all();

        foreach ($redirects as $redirect) {
            $from = trim($redirect->from);

            if ($from == trim($path)) {
                return redirect(trim($redirect->to), 301);
            }
        }

        return $next($request);
    }
}
