<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use View;

class ContentController extends BaseController
{
    public function manage()
    {
        return View::make('argon::content.manage');
    }

}
