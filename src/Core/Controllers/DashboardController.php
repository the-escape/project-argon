<?php

namespace Escape\Argon\Core\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Illuminate\Http\Request;
use Mockery\Exception;
use View;
use Slack;
use Auth;

class DashboardController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        parent::__construct($request);
    }

    public function dashboard()
    {
        throw new Exception('erooorroorororororo',110101);

//        $e = new Exception('Sample Error', 0);
//
//        $dump  = Auth::user() ? 'User: ' . Auth::user()->name.' ('.Auth::user()->id.")\n":'guest';
//        $dump .= (Auth::user() ? 'Email: ' . Auth::user()->email:'')."\n\n";
//
//        $dump_all = [
//            'POST' => $_POST,
//            'GET' => $_GET,
//            'FILES' => @$_FILES,
//            'SESSION' => @$_SESSION,
//            'COOKIE' => $_COOKIE,
//            'SERVER' => $_SERVER
//        ];
//
//        foreach($dump_all as $name => $data)
//        {
//            if ($data)
//            {
//                foreach($data as $k => $v)
//                {
//                    $dump .= $name." - ".$k.": ".$v."\n";
//                }
//                $dump .= "\n";
//            }
//            else
//            {
//                $dump .= $name." empty\n\n";
//            }
//        }
//
//        $error_msg = "Exception was thrown in ".
//            $e->getFile()." on line ".$e->getLine().
//            " with message ".$e->getMessage()."\n".
//            "\n\nInfo about the request:\n".
//            "```".$dump."```";
//
//
//        $attachment = [
//            "color" => 'danger',
//            "title" => $e->getMessage().' on '.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'https':'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
//            "title_link" => 'http://'.$_SERVER['HTTP_HOST'],
//            "text" => $error_msg,
//            "mrkdwn" => true
//        ];
//
//        Slack::attach($attachment)->send();



        return View::make('argon::page.overview', []);
    }
}
