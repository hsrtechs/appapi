<?php

if (! function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return app('hash')->make($value, $options);
    }
}

if(! function_exists('setErrors'))
{
    function setErrors($errors)
    {
        if(!is_array($errors))
            $errors = json_decode($errors);
        $_SESSION['errors'] = $errors;
    }
}

if(! function_exists('hasErrors'))
{
    function hasErrors()
    {
        return !empty($_SESSION['errors']);
    }
}

if(! function_exists('getErrors'))
{
    function getErrors($clear = true)
    {
        if(hasErrors())
        {
            $error = $_SESSION['errors'];
            if($clear)
                unset($_SESSION['errors']);

            return $error;
        }
        else
            return false;
    }
}

if(! function_exists('setInputs'))
{
    function setInputs($inputs)
    {
        if(!is_array($inputs))
            $inputs = json_decode($inputs);
        $_SESSION['input'] = $inputs;
    }
}

if(! function_exists('hasInputs'))
{
    function hasInputs()
    {
        return !empty($_SESSION['input']);
    }
}

if(! function_exists('hasInput'))
{
    function hasInput($input)
    {
        return !empty($_SESSION['input'][$input]);
    }
}

if(! function_exists('getInputs'))
{
    function getInputs($clear)
    {
        return $_SESSION['input'] ?? false;
    }
}


if(! function_exists('getInput'))
{
    function getInput($input, $clear = true)
    {
        if(hasInput($input))
        {
            $return = $_SESSION['input'][$input];

            if($clear)
                unset($_SESSION['input'][$input]);

            return $return;
        }
        return false;
    }
}

