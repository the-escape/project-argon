<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;

class CreateController extends BaseController
{
    function setMiddleware()
    {
        return [
            'auth'
        ];
    }

    function setTabs()
    {
        return [
            new Tab('PAGE CONTENT', '/admin/pages/create'),
            new Tab('ATTRIBUTES', ''),
            new Tab('SEO', ''),
            new Tab('REVISIONS', ''),
        ];
    }

    public function page()
    {
        return view('argon.entity::pages.create', [
            'name' => 'New Page',
        ]);
    }
}
