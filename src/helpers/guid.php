<?php

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
    $newVar = [];
    foreach ($var as $key => $value) {
        $newVar[$key] = $value;
    }

    return $newVar;
}

function spam_check($input, $min_time_to_fill=2)
{
    // If the bot catcher field is populated or the form was loaded and submitted in under $min_time_to_fill seconds
    // then we assume it has been submitted by a spam bot
    if (!empty($input['catcher']) || ( (time()-$min_time_to_fill) < @$input['timestamp'])) {
        // Add the users user agent to the input data and log the data
        $input['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];

        \Log::info("Spam prevented.", $input);

        // Abort the process because this is spam
        abort(200, "Spam prevented.");
    }

    return true;
}

/**
 * Validated provided email and submits to it provided values.
 * In case email fails, logs values and emails digital team to handle the issue.
 * @param $email
 * @param array $input
 * @return bool
 */
function email_submission($email, array $input, $subject='')
{
    // validate the email supplied to make sure we can send values without a fail
    $validator = \Validator::make(['email' => $email], ['email' => 'required|email']);

    // log error and values, so we don't loose anything at all
    if ($validator->fails())
    {
        $error = "Invalid email address \"{$email}\" supplied to ".__METHOD__." in ".__FILE__;
        \Log::error($error." Submission details saved below.");

        $msg[] = "Submitted values:";

        foreach ($input as $k => $v)
        {
            $msg[] = "{$k}: $v";
        }

        if ($msg = format_message($msg, PHP_EOL))
        {
            Log::info($msg);
        }

        $data['error'] 		= $error." Submission details saved in error log.";
        $data['trace'] 		= '';
        $data['line'] 		= __LINE__;
        $data['file'] 		= __FILE__;

        \Mail::send('argon::emails.error', $data, function($message)
        {
            $message
                ->to('pawel-nowak@the-escape.co.uk', 'Error reporting')
                ->subject('Website - Error!');
        });

        return false;
    }

    // email address is OK, format a message and email it
    $msg = "<h3>Submitted values</h3><br>";

    foreach ($input as $k => $v)
    {
        $msg .= "<p><strong>{$k}:</strong> $v</p>";
    }

    if (!$subject)
    {
        $subject = "Form submission (".date('Y-m-d H:i:s').")";
    }

    \Mail::send('argon::emails.template', ['content'=>$msg], function ($message) use ($email, $subject)
    {
        $message->to($email)->subject($subject);
    });

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
 * Return null if no items, or requested page number less than 1 to greater than 'pages_count'.
 *
 * @param array $items
 * @param int $per_page (-1 or any positive int, not 0)
 * @param null $current_page
 * @return null|pagination array
 */
function easyPagination(array $items, $per_page=10, $current_page_number=null)
{
    if ($items)
    {
        $pagination['items_count'] = count($items);
        $pagination['per_page'] = (preg_match('/^-1|[1-9][0-9]*$/', $per_page))
            ? (int) $per_page
            : trigger_error("Invalid 'per_page' argument supplied '{$per_page}'.", E_USER_ERROR);
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

    return null;
}


function getUrlWithQueryString($url=null, array $set=[], array $unset=[])
{
    if ($url === null) {
        $url = $_SERVER['REQUEST_URI'];
    }

    $url = parse_url($url, PHP_URL_PATH);
    $url = rtrim($url, '?&');

    parse_str($_SERVER['QUERY_STRING'], $qs);

    $qs = array_merge($qs, $set);

    foreach ($unset as $key) {
        unset($qs[$key]);
    }

    if ($qs) {

        $url .= (strpos($url, '?')) ? '&' : '?';
        $url .= http_build_query($qs);
    }

    return $url;
}