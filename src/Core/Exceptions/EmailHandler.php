<?php

namespace Escape\Argon\Core\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;

use \Auth;
use \Mail;

class EmailHandler extends ExceptionHandler
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
        if ($e instanceof TokenMismatchException)
        {
            return;
        }

        $errorCode = method_exists($e, 'getStatusCode')
            ? $e->getStatusCode()
            : $e->getCode();

        if (in_array($errorCode, [404, 405]))
        {
            return;
        }

        $app = app();

        if (!$app->isLocal())
        {
            $this->sendEmailMessage($e);
        }

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

    public function sendEmailMessage($e)
    {
        $dump = date('Y-m-d H:i:s'). "<br><br>";
        $dump .= Auth::user() ? 'User: ' . Auth::user()->name.' ('.Auth::user()->id.")<br>":'Guest user';
        $dump .= (Auth::user() ? 'Email: ' . Auth::user()->email:'')."<br><br>";

        $dump_all = [
            'POST' => $_POST,
            'GET' => $_GET,
            'FILES' => @$_FILES,
            'SESSION' => @$_SESSION,
            'COOKIE' => $_COOKIE,
        ];

        foreach($dump_all as $name => $data)
        {
            if ($data)
            {
                foreach($data as $k => $v)
                {
                    $dump .= $name." - ".$k.": ".$v."<br>";
                }
                $dump .= "<br>";
            }
            else
            {
                $dump .= $name." empty<br><br>";
            }
        }

        $allowed_server_variables = [
            'argv',
            'argc',
            'GATEWAY_INTERFACE',
            'SERVER_ADDR',
            'SERVER_NAME',
            'SERVER_SOFTWARE',
            'SERVER_PROTOCOL',
            'REQUEST_METHOD',
            'REQUEST_TIME',
            'REQUEST_TIME_FLOAT',
            'QUERY_STRING',
            'DOCUMENT_ROOT',
            'HTTP_ACCEPT',
            'HTTP_ACCEPT_CHARSET',
            'HTTP_ACCEPT_ENCODING',
            'HTTP_ACCEPT_LANGUAGE',
            'HTTP_CONNECTION',
            'HTTP_HOST',
            'HTTP_REFERER',
            'HTTP_USER_AGENT',
            'HTTPS',
            'REMOTE_ADDR',
            'REMOTE_HOST',
            'REMOTE_PORT',
            'REMOTE_USER',
            'REDIRECT_REMOTE_USER',
            'SCRIPT_FILENAME',
            'SERVER_ADMIN',
            'SERVER_PORT',
            'SERVER_SIGNATURE',
            'SCRIPT_NAME',
            'REQUEST_URI',
        ];

        foreach ($allowed_server_variables as $srv_var_name)
        {
            $srv_var_val = array_key_exists($srv_var_name, $_SERVER) ? $_SERVER[$srv_var_name] : null;
            $dump .= $srv_var_val ? "SERVER - ".$srv_var_name.": ".$srv_var_val."<br>" : '';
        }

        $error_msg = "Exception was thrown in ".
            $e->getFile()." on line ".$e->getLine().
            " with message <br><pre>".$e->getMessage()."</pre>".
            "<br><br>Info about the request:<br><br>".
            "<pre>".$dump."</pre>";


        Mail::send('argon::emails.template', ['content' => $error_msg], function ($message) {
            $message->to('digital@the-escape.co.uk');
            $message->subject('Error - '.$_SERVER['HTTP_HOST']);
        });
    }
}
