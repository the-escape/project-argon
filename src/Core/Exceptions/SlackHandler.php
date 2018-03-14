<?php

namespace Escape\Argon\Core\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;

use \Auth;
use \Slack;

class SlackHandler extends ExceptionHandler
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

        if (in_array($errorCode, [404, 405, 503]))
        {
            return;
        }

        $app = app();

        if (!$app->isLocal())
        {
            $this->sendSlackMessage($e);
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

    public function sendSlackMessage($e)
    {
        $dump = date('Y-m-d H:i:s'). "\n\n";
        $dump .= Auth::user() ? 'User: ' . Auth::user()->name.' ('.Auth::user()->id.")\n":'Guest user';
        $dump .= (Auth::user() ? 'Email: ' . Auth::user()->email:'')."\n\n";


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
                    $dump .= $name." - ".$k.": ".print_r($v, 1)."\n";
                }
                $dump .= "\n";
            }
            else
            {
                $dump .= $name." empty\n\n";
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
            $dump .= $srv_var_val ? "SERVER - ".$srv_var_name.": ".print_r($srv_var_val, 1)."\n" : '';

        }

        $error_msg = "Exception was thrown in ".
            $e->getFile()." on line ".$e->getLine().
            " with message \"".$e->getMessage()."\"\n".
            "\n\nInfo about the request:\n".
            "```".$dump."```";

        $https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'];
        $host = isset($_SERVER['HTTP_HOST']) ? ($https ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] : config('app.url');

        $attachment = [
            "color" => 'danger',
            "title" => $e->getMessage().' on '.$host.$_SERVER['REQUEST_URI'],
            "title_link" => 'http://'.$_SERVER['HTTP_HOST'],
            "text" => $error_msg,
            "mrkdwn" => true
        ];

        Slack::attach($attachment)->send();
    }
}
