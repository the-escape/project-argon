<?php

namespace Escape\Argon\EntityManagement\Helpers;

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
}
