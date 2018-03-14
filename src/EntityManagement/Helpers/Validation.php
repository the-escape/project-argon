<?php

namespace Escape\Argon\EntityManagement\Helpers;

use Escape\Argon\Exceptions\SpamException;

class Validation
{
    const REGEX_FLOAT = '/^[-+]?[0-9]*\.?[0-9]+$/';

    // flex regex to match following types of international and british phone numbers:
    // (0) 125 1 2 3633 x4567
    // 1256 334567 x123
    // +44 (0) 125 1 2 3633 x4567
    // +44 1256 334567 x123
    // +44 (0) 1256 334567
    // +441256334567
    // +44(0)1256334567 x123
    // +441256334567
    // +44 1256 334567 x1
    const REGEX_PHONE = '/^(\+\d+\s?)?(\(0\)\s?)?([\d]+\s?)+(\s?x\d+)?$/';

    public static function getErrorClass($errors, $field_name, $errorClass = 'error')
    {
        return (is_object($errors)
            && ($errors instanceof \Illuminate\Support\ViewErrorBag && $errors->has($field_name)))
            ? $errorClass
            : '';
    }

    /**
     * Asserts spam submissions.
     * If the hidden `_catcher` field is populated or the form was loaded and submitted in under $min_time_to_fill seconds - assume spam.
     *
     * To prevent fiddling with timestamp value, set session `_timestamp` field before loading page with the form, just like csrf `_token` field does.
     * $request->session()->put('_timestamp', time()));
     *
     * Then use it in the form like so:
     * <input type="hidden" name="_timestamp" value="{{ $request->session()->get('_timestamp') }}">
     * <input type="hidden" name="_catcher">
     * <input type="hidden" name="_token" value="{{ csrf_token() }}">
     *
     *
     * @param $input
     * @param int $min_time_to_fill
     * @return bool
     * @throws SpamException
     */
    public static function spamCheck($min_time_to_fill=2)
    {
        $request = request();

        if (!$request->exists("_catcher"))
        {
            throw new SpamException("Spam prevented, undefined field `_catcher`.");
        }

        if (!$request->exists("_timestamp"))
        {
            throw new SpamException("Spam prevented, undefined field `_timestamp`.");
        }

        if ($request->input("_catcher") !== "")
        {
            throw new SpamException("Spam prevented, `_catcher` field not empty.");
        }

        $sessionTimestamp = $request->session()->get('_timestamp');

        if (is_null($sessionTimestamp))
        {
            throw new SpamException("Spam prevented, undefined session field `_timestamp`.");
        }

        $requestTimestamp = $request->input('_timestamp');

        if ($sessionTimestamp != $requestTimestamp)
        {
            throw new SpamException("Spam prevented, invalid `_timestamp` field.");
        }

        if ((time() - $min_time_to_fill) <= $requestTimestamp)
        {
            throw new SpamException("Spam prevented, form submitted under {$min_time_to_fill} seconds.");
        }

        return true;
    }
}

