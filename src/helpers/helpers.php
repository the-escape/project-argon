<?php

/**
 * Returns a version of the current Laravel installation
 *
 * @return string
 */
function laravelVersion()
{
    return App::VERSION();
}

/**
 * Laravel version check
 *
 * @return boolean
 */
function isLaravelVersionPre($version)
{
    return version_compare(laravelVersion(), $version, "lt");
}

/**
 * Laravel version check
 *
 * @return boolean
 */
function isLaravelVersionPost($version)
{
    return version_compare(laravelVersion(), $version, "gt");
}
