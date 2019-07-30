<?php

/**
 * Returns a version of the current Laravel installation
 *
 * @return string
 */
if (!function_exists('laravelVersion'))
{
    function laravelVersion()
    {
        return App::VERSION();
    }
}

/**
 * Laravel version check
 *
 * @return boolean
 */
if (!function_exists('isLaravelVersionPre'))
{
    function isLaravelVersionPre($version)
    {
        return version_compare(laravelVersion(), $version, "lt");
    }
}

/**
 * Laravel version check
 *
 * @return boolean
 */
if (!function_exists('isLaravelVersionPost'))
{
    function isLaravelVersionPost($version)
    {
        return version_compare(laravelVersion(), $version, "gt");
    }
}

/**
 * IE11 check
 *
 * @return boolean
 */
if (!function_exists('isIE11'))
{
    function isIE11()
    {
        $userAgent = request()->header('User-Agent', '');

        return strpos($userAgent, 'Trident/7.0; rv:11.0') !== false;
    }
}

/**
 * Checks if logged in user is an Admin
 *
 * @return boolean
 */
if (!function_exists('isAdmin'))
{
    function isAdmin()
    {
        $user = Auth::user();
        return $user ? $user->hasRole('Admin') : false;
    }
}

/**
 * Checks if the user is from The Escape location or using local environment
 *
 * @return boolean
 */
if (!function_exists('isEscape'))
{
    function isEscape()
    {
        $escape_ips = [
            '127.0.0.1',
            '192.168.10.1', // homestead host machine
            '185.74.236.118' // escape office
        ];

        return in_array($_SERVER["REMOTE_ADDR"], $escape_ips);
    }
}
