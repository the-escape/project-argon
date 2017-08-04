<?php

namespace Escape\Argon\Core\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use \Auth;
use \Slack;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        $this->sendSlackMessage($e);

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        return parent::render($request, $e);
    }

    public function sendSlackMessage($e)
    {
        $dump  = Auth::user() ? 'User: ' . Auth::user()->name.' ('.Auth::user()->id.")\n":'guest';
        $dump .= (Auth::user() ? 'Email: ' . Auth::user()->email:'')."\n\n";

        $dump_all = [
            'POST' => $_POST,
            'GET' => $_GET,
            'FILES' => @$_FILES,
            'SESSION' => @$_SESSION,
            'COOKIE' => $_COOKIE,
            'SERVER' => $_SERVER
        ];

        foreach($dump_all as $name => $data)
        {
            if ($data)
            {
                foreach($data as $k => $v)
                {
                    $dump .= $name." - ".$k.": ".$v."\n";
                }
                $dump .= "\n";
            }
            else
            {
                $dump .= $name." empty\n\n";
            }
        }

        $error_msg = "Exception was thrown in ".
            $e->getFile()." on line ".$e->getLine().
            " with message \"".$e->getMessage()."\"\n".
            "\n\nInfo about the request:\n".
            "```".$dump."```";


        $attachment = [
            "color" => 'danger',
            "title" => $e->getMessage().' on '.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'https':'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
            "title_link" => 'http://'.$_SERVER['HTTP_HOST'],
            "text" => $error_msg,
            "mrkdwn" => true
        ];

        Slack::attach($attachment)->send();
    }
}
