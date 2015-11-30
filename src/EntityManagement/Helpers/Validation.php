<?php namespace Escape\Argon\EntityManagement\Helpers;


class Validation
{

    const REGEX_FLOAT = '/^[-+]?[0-9]*\.?[0-9]+$/';
    const REGEX_PHONE = '/^(\+\d+\s?)?(\(0\)\s?)?([\d]+\s?)+(\s?x\d+)?$/';


    public static function getErrorClass($errors, $field_name, $errorClass='error')
    {
        return (is_object($errors) && ($errors instanceof \Illuminate\Support\ViewErrorBag && $errors->has($field_name)))
            ? $errorClass
            : '';
    }

}
