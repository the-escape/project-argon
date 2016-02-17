<?php

namespace Escape\Argon\Frontend\Controllers;

use Exception;
use Illuminate\Routing\Controller;

class CmsController extends Controller
{
    public function getViewNameForType($typeId)
    {
        $views = config('argon.views');

        if (!array_key_exists($typeId, $views)) {
            throw new Exception('View template not defined for type ' . $typeId);
        }

        return $views[$typeId];
    }
}
