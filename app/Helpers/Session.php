<?php
namespace App\Helpers;


use function session_destroy;

class Session
{
    public static function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public static function put($key,$value = '')
    {
        $_SESSION[$key] = $value;
        return $value;
    }

    public static function exists($key)
    {
        return !empty($_SESSION[$key]);
    }

    public static function delete($key)
    {
        if(self::exists($key))
            unset($_SESSION[$key]);

        return true;
    }

    public static function destroy()
    {
        session_destroy();
        return true;
    }

}