<?php

namespace Escape\Argon\Entity\Http\Controllers;

use Illuminate\Routing\Controller;
use League\Fractal\Manager;

class BaseApiController extends Controller
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new Manager();
    }
}
