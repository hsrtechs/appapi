<?php

use App\Admin;
use App\Helpers\Session;

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

if(! function_exists('addError'))
{
    function addError($error)
    {
        if(!is_array($error))
            $error = [$error];

        if(hasErrors())
            array_push($_SESSION['errors'],[$error]);
        else
            $_SESSION['errors'] = [$error];
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

            if(!is_array($error)){
                if(is_object($error))
                {
                    $error = json_decode(json_encode($error),true);
                }
                else $error = json_decode($error,true);
            }


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
    function getInputs()
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


if(! function_exists('APIResponse'))
{
    function APIResponse($request, Array $data = [], int $code = 200)
    {
        $response = [
            'response_code' => $code,
            'request' => $request,
            'data' => $data,
        ];
        return response($response, $code);
    }
}

if(! function_exists('APIError'))
{
    function APIError($request, Array $data = ["Request Failed"], int $code = 500)
    {
        $response = [
            'error_code' => $code,
            'request' => $request,
            'error' => $data,
        ];
        return response($response, $code);
    }
}

if(! function_exists('loggedAdmin'))
{
    function loggedAdmin()
    {
        $admin = Admin::find((Session::get('admin')));
        return $admin ? $admin->first() : false;
    }
}

if(! function_exists('status'))
{
    function status(Array $input = []) : array
    {
        if(!empty($_GET['status']))
            $status = $_GET['status'] === 'true' ? true : false;
        else
            $status = NULL;

        $input['status'] = $status;
        return $input;
    }
}

if (!function_exists('getReferralCredits')) {
    function getReferralCredits(): float
    {
        $c = env('REF_CREDITS', 5);
        return is_numeric($c) ? floatval($c) : 0;
    }
}
