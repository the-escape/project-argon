<?php

namespace Escape\Argon\Navigation\Controllers;

use Escape\Argon\Core\Controllers\BaseController;

class NavigationController extends BaseController
{
    public function manage()
    {
        return view('argon_navigation::manage', []);
    }
}
