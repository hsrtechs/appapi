<?php
namespace App\Helpers;


use function decrypt;
use function encrypt;
use function session_destroy;

class Session
{
    public static function get($key,bool $decrypt = true)
    {
        $return = self::exists($key) ? ($_SESSION[$key]) : false;
        return $decrypt ? decrypt($return) : $return;
    }

    public static function put($key,$value = '',$encrypt = true)
    {
        $_SESSION[$key] = $encrypt ? encrypt($value) : $value;
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