<?php
use Escape\Argon\Menus\Eloquent\MenuRepository;
use Illuminate\Support\ViewErrorBag;
/**
 * @return Escape\Argon\EntityManagement\Eloquent\EntityCache - registered as singleton in Escape\Argon\EntityManagement\EntityManagementServiceProvider
 */
function entityCache()
{
    return app()->make('entityCache');
}

/**
 * @return Escape\Argon\Media\Helpers\ImageOptim - registered as singleton in Escape\Argon\Media\MediaServiceProvider
 */
function imageOptim()
{
    return app()->make('imageOptim');
}

/**
 * Attach all menus to app for further sharing to avoid querying same stuff again.
 * @param null $slug
 * @param null $default
 * @return mixed $menu or $menus
 */
function menuCache($slug=null, $default=null)
{
    $bound = app()->bound('menus');

    if (!$bound)
    {
        app()->singleton('menus', function()
        {
            $menuRepository = app()->make(MenuRepository::class);
            $menus = $menuRepository->all();
            return $menus;
        });
    }

    $menus = app()->make("menus");

    if (!is_null($slug))
    {
        foreach ($menus as $menu)
        {
            if ($menu->slug == $slug)
            {
                return $menu;
            }
        }

        return $default;
    }

    return $menus;
}

function isAdminSection()
{
    return sprintf('/%s', request()->segment(1)) === config('argon.admin_route_prefix');
}

function getAssetPath($filename)
{
    $url = parse_url($filename);
    $path = array_key_exists('path', $url) ? $url['path'] : '';
    $query = array_key_exists('query', $url) ? '?'.$url['query'] : '';
    $fragment = array_key_exists('fragment', $url) ? '#'.$url['fragment'] : '';
    $filename = trim($path, ' \t\n\r\0\x0B/');
    $path = public_path($filename);
    $pathinfo = pathinfo($path);
    $manifest = $pathinfo['dirname'].DIRECTORY_SEPARATOR.'manifest.json';

    if (is_readable($manifest))
    {
        $manifest = json_decode(file_get_contents($manifest), TRUE);
        $basename = $pathinfo['basename'];

        if (array_key_exists($basename, $manifest))
        {
            $filename = str_replace($basename, $manifest[$basename], $filename);
        }
    }

    return '/'.$filename.$query.$fragment;
}

function guid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),
        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,
        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,
        // 48 bits for "node"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

function toArray($var)
{
    if (is_array($var))
    {
        return $var;
    }

    $array = [];

    if (is_object($var))
    {
        foreach ($var as $key => $value)
        {
            $array[$key] = $value;
        }

        return $array;
    }

    if (is_null($var))
    {
        return $array;
    }

    if (is_scalar($var))
    {
        return [$var];
    }

    if (is_resource($var))
    {
        return $array;
    }

    return $array;
}

/**
 * @deprecated Not recommended. Use \Escape\Argon\EntityManagement\Helpers\Validation::spamCheck instead.
 * @param $input
 * @param int $min_time_to_fill
 * @return bool
 */
function spam_check($input, $min_time_to_fill=2)
{
    // If the bot catcher field is populated or the form was loaded and submitted in under $min_time_to_fill seconds
    // then we assume it has been submitted by a spam bot
    if (($input['catcher']!='') || ( (time()-$min_time_to_fill) < $input['timestamp'])) {
        // Add the users user agent to the input data and log the data
        $input['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];

        \Log::info("Spam prevented.", $input);

        // Abort the process because this is spam
        abort(200, "Spam prevented.");
    }

    return true;
}

/**
 * Validate provided email and submits to it provided values.
 * In case email fails, logs values and emails digital team to handle the issue.
 * @param $email
 * @param array $input
 * @param string $subject - optional
 * @return bool
 */
function email_submission($email, array $input, $subject='')
{
    // validate the email supplied to make sure we can send values without a fail
    $validator = \Validator::make(['email' => $email], ['email' => 'required|email']);

    $timestamp = date('Y-m-d H:i:s');

    if ($validator->fails())
    {
        $e = new Exception("Invalid email address \"{$email}\" supplied to ".__METHOD__." in ".__FILE__);
        alert_escape($e, $timestamp);
        return false;
    }

    try
    {
        if (!$subject)
        {
            $subject = "Form submission @ {$timestamp}";
        }

        \Mail::send('argon::emails.template', ['content'=>$input], function ($message) use ($email, $subject)
        {
            $message->to($email)->subject($subject);
        });
    }
    catch (Exception $e)
    {
        alert_escape($e, $timestamp);
        return false;
    }

    return true;
}

/**
 * Log error and submitted input, then email Escape
 * @param Exception $error
 * @param string $timestamp - optional
 */
function alert_escape(Exception $e, $timestamp=null)
{
    if (is_null($timestamp))
    {
        $timestamp = date('Y-m-d H:i:s');
    }

    $error = format_error($e);
    $error['timestamp'] = $timestamp;

    \Log::error($error);

    email_escape($error);
}

/**
 * Email Escape using separate escape email config.
 * This is useful and independent form clients mailjet.
 * @param $data
 * @param string $subject - optional
 * @param string $template - optional
 * @param string $fromAddress - optional
 * @param string $fromName - optional
 * @param array $recepients - optional
 * @return bool
 */
function email_escape($data, $subject=null, $template='argon::emails.error', $fromAddress="error@the-escape.co.uk", $fromName="Error reporting", array $recepients=null)
{
    try
    {
        if (is_null($subject))
        {
            $subject = "Error @ ".url();
        }

        if (is_null($recepients))
        {
            $recepients = ['digital@the-escape.co.uk'];
        }

        $ERROR_MAIL_HOST = env("ERROR_MAIL_HOST", 'in-v3.mailjet.com');
        $ERROR_MAIL_PORT = env("ERROR_MAIL_PORT", 587);
        $ERROR_MAIL_ENCRYPTION = env("ERROR_MAIL_ENCRYPTION", 'tls');
        $ERROR_MAIL_USERNAME = env("ERROR_MAIL_USERNAME", '78de28444e70bc50ff74612ecc20caf5');
        $ERROR_MAIL_PASSWORD = env("ERROR_MAIL_PASSWORD", 'b22630a1b942e81558b3e40c1dd3fec3');
        $ERROR_MAIL_FROM_ADDRESS = env("ERROR_MAIL_FROM_ADDRESS", $fromAddress);
        $ERROR_MAIL_FROM_NAME = env("ERROR_MAIL_FROM_NAME", $fromName);


        // Backup your default mailer
        $backup = \Mail::getSwiftMailer();

        // Setup your mailer
        $transport = Swift_SmtpTransport::newInstance($ERROR_MAIL_HOST, $ERROR_MAIL_PORT, $ERROR_MAIL_ENCRYPTION);
        $transport->setUsername($ERROR_MAIL_USERNAME);
        $transport->setPassword($ERROR_MAIL_PASSWORD);
        // Any other mailer configuration stuff needed...

        $gmail = new Swift_Mailer($transport);

        // Set the mailer as gmail
        \Mail::setSwiftMailer($gmail);

        // Send your message
        \Mail::send($template, ['content'=>$data], function($message) use ($subject, $ERROR_MAIL_FROM_ADDRESS, $ERROR_MAIL_FROM_NAME, $recepients)
        {
            $message
                ->from($ERROR_MAIL_FROM_ADDRESS, $ERROR_MAIL_FROM_NAME)
                ->to($recepients)
                ->subject($subject);
        });

        // Restore your original mailer
        \Mail::setSwiftMailer($backup);

    }
    catch (Exception $e)
    {
        \Log::error(format_message($e->getMessage(), PHP_EOL));
        return false;
    }

    return true;
}


function format_message($message, $glue='<br>')
{
    if ($message)
    {
        if (is_array($message))
        {
            $message = array_filter($message);
            // compress array to string format
            $message = implode($glue, $message);
        }

        return $message;
    }

    return '';
}

/**
 * Prepare error data array
 * @param Exception $e
 * @return array $data
 */
function format_error(Exception $e)
{
    $data['msg'] 	    = $e->getMessage();
    $data['trace'] 		= $e->getTraceAsString();
    $data['line'] 		= $e->getLine();
    $data['file'] 		= $e->getFile();

    $data['post']       = empty($_POST) ? request()->all() : $_POST;
    $data['get']        = @$_GET;
    $data['files']      = @$_FILES;
    $data['session']    = @$_SESSION;
    $data['cookie']     = @$_COOKIE;

    $data['server']     = [];

    // filer server var as they will contain sensitive details from .env file
    $serverVariables = [
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

    foreach ($serverVariables as $serverVariable)
    {
        $data['server'][$serverVariable] = array_key_exists($serverVariable, $_SERVER) ? $_SERVER[$serverVariable] : '';
    }

    return $data;
}


/**
 * Easy pagination.
 * Returns array[
 *  'items_count' => total items count,
 *  'per_page' => items per page,
 *  'pages' => array of paginated items,
 *  'current_page_number' => current page number (offset),
 *  'page' => current page items,
 *  'pages_count' => total number of pages,
 *  'page_count' => total number of items on current page,
 *  'page_prev' => previous page number or null,
 *  'page_next' => next page number or null,
 *  'page_items_from' => number of item being returned from total items that is the first within current 'page' items,
 *  'page_items_to' => number of item being returned from total items that is the last within current 'page' items array,
 * ]
 * Return null if no items, or requested page number less than 1 or greater than 'pages_count'.
 *
 * @param array $items
 * @param int $per_page (-1 or any positive int, not 0)
 * @param null $current_page
 * @return null|pagination array
 */
function easyPagination(array $items, $per_page=10, $current_page_number=null)
{
    if (!$items)
    {
        return null;
    }

    $pagination['items_count'] = count($items);
    $pagination['per_page'] = (preg_match('/^-1|[1-9][0-9]*$/', $per_page))
        ? (int) $per_page
        : 10;
    $pagination['pages'] = ($pagination['per_page']  > 0) ? array_chunk($items, $pagination['per_page']) : array_chunk($items, count($items));
    $pagination['pages_count'] = count($pagination['pages']);

    // get the integer value of a variable
    $current_page_number = ($current_page_number)
        ? $current_page_number
        : (isset($_GET['page']) ? $_GET['page'] : 1);

    // valid page can only be a non-negative integer
    $pagination['current_page_number'] = (preg_match('/^[1-9][0-9]*$/', $current_page_number)) ? (int) $current_page_number : null;

    if ($pagination['current_page_number'] > $pagination['pages_count'])
    {
        return null;
    }

    if ($pagination['current_page_number'] < 1)
    {
        return null;
    }

    // since arrays indexes are 0 based subscribe 1 from current page
    // and see if corresponding index exists in pages array
    // valid page can only be a non-negative integer
    $pagination['page'] = isset($pagination['pages'][$pagination['current_page_number']-1]) ? $pagination['pages'][$pagination['current_page_number']-1] : null;

    $pagination['page_count'] = count($pagination['page']);

    $pagination['page_prev'] = (($pagination_previous = $pagination['current_page_number'] - 1) < 1)
        ? null
        : $pagination_previous;

    $pagination['page_next'] = (($pagination_next = $pagination['current_page_number'] + 1) > $pagination['pages_count'])
        ? null
        : $pagination_next;

    $page_offset = ($pagination['current_page_number'] * $pagination['per_page']) - $pagination['per_page'];

    $pagination['page_items_from'] = $page_offset + 1;

    $pagination['page_items_to'] = $page_offset + $pagination['page_count'];

    return $pagination;
}


function paginationPresenter($pagination, $hellip='...', $minThreshold=1, $maxThreshold=2, callable $callback=null)
{
    $output = [];

    $current_page_number = $pagination['current_page_number'];

    $maxThreshold = $pagination['pages_count'] - $maxThreshold;

    $range = range(1, $pagination['pages_count']);


    foreach ($range as $num)
    {
        if ($current_page_number == $num)
        {
            $output[] = $num;
            continue;
        }

        if ($current_page_number == ($num-1))
        {
            $output[] = $num;
            continue;
        }

        if (($num+1) <= $pagination['pages_count'] && $current_page_number == ($num+1))
        {
            $output[] = $num;
            continue;
        }

        if ($num <= $minThreshold)
        {
            $output[] = $num;
            continue;
        }

        if ($num > $maxThreshold)
        {
            $output[] = $num;
            continue;
        }

        $output[] = $hellip;
    }

    $v = '';

    // collapse duplicate segments of  $hellip values into single instance
    foreach ($output as $key => $value)
    {
        if ($value != $v)
        {
            $v = $value;
        }
        else
        {
            unset($output[$key]);
        }
    }

    // if defined apply callback to each output item
    if ($callback)
    {
        foreach ($output as $key => &$value)
        {
            $value = call_user_func_array($callback, [$value, $hellip, $current_page_number]);
        }
    }

    return $output;
}


function getUrlWithQueryString(array $set=[], array $unset=[], $url=null, $encode=true)
{
    if ($url === null) {
        $url = $_SERVER['REQUEST_URI'];
    }

    $url = parse_url($url, PHP_URL_PATH);
    $url = rtrim($url, '?&');

    if(isset($_SERVER['QUERY_STRING']))
    {
        parse_str($_SERVER['QUERY_STRING'], $qs);
    }
    else
    {
        $qs = array();
    }

    $qs = array_merge($qs, $set);

    foreach ($unset as $key) {
        unset($qs[$key]);
    }

    if ($qs) {
        $url .= (strpos($url, '?')) ? '&' : '?';
        $url .= http_build_query($qs);
    }

    if (!$encode)
    {
        $url = urldecode($url);
        $url = preg_replace('/\s+/', '+', $url);
    }

    return $url;
}

function getUrlWithQueryStringNoEncoding(array $set=[], array $unset=[], $url=null)
{
    return getUrlWithQueryString($set, $unset, $url, false);
}

function getUrlNoQueryString($url=null)
{
    if (is_null($url))
    {
        $url = $_SERVER['REQUEST_URI'];
    }

    return parse_url($url, PHP_URL_PATH);
}

/**
 * Sorts collection looking at CMS field values
 * @param $collection
 * @param $field
 * @param string $direction asc|desc
 * @return mixed
 */
function sortByField($collection, $field, $direction='asc')
{
    $temp = $collection->splice(0, $collection->count());

    $directions = ['asc', 'desc'];
    if (!in_array($direction, $directions))
    {
        throw new \RuntimeException("Invalid sorting direction. Expected asc|desc, '$direction' given.");
    }

    $sorted = [];

    foreach($temp as $item)
    {
        $f = $item->field($field);

        if ($f instanceof DatetimeFieldValue)
        {
            $v = $f->timestamp;
        }
        else
        {
            $v = (string) $f;
        }

        $sorted[] = $v;
    }

    natcasesort($sorted);

    if ($direction == 'desc')
    {
        $sorted = array_reverse($sorted);
    }

    foreach ($sorted as $sortedValue)
    {
        foreach($temp as $i => $item)
        {
            $itemValue = (string) $item->field($field);

            if ($sortedValue == $itemValue)
            {
                $collection->push($item);
                $temp->forget($i);
                break;
            }
        }
    }

    return $collection;
}


function isJson($value)
{
    if (!is_string($value))
    {
        return false;
    }

    json_decode($value);

    return (json_last_error() == JSON_ERROR_NONE);
}


function hasError($errors, $field_name)
{
    return (is_object($errors) && ($errors instanceof ViewErrorBag && $errors->has($field_name)));

}

function getError($errors, $field_name)
{
    if(is_object($errors) && ($errors instanceof ViewErrorBag && $errors->has($field_name)))
    {
        $error = $errors->get($field_name);

        if(is_array($error))
        {
            $error = implode('<br>', $error);
        }

        return $error;
    }

    return '';
}

/**
 * Unified way of presenting messages regardless if the value passes was a string, array or validator object.
 *
 * @param $message
 * @param null $default
 * @return array|null
 */
function getMessage($message, $default=null)
{
    if (is_null($message))
    {
        return $default;
    }

    if (is_scalar($message))
    {
        return [$message];
    }

    if (is_array($message))
    {
        return $message;
    }

    if (is_object($message))
    {
        if ($message instanceof Illuminate\Support\MessageBag)
        {
            return $message->all();
        }

        if ($message instanceof Illuminate\Support\ViewErrorBag)
        {
            $bags = $message->getBags();
            $msg = [];

            foreach ($bags as $bag)
            {
                $msg = array_merge($msg, $bag->all());
            }

            if ($msg)
            {
                return $msg;
            }
        }

        if (method_exists($message, "all"))
        {
            return $message->all();
        }

        return toArray($message);
    }

    return $default;
}
