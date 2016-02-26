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
