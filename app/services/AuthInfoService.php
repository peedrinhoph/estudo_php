<?php

namespace app\services;

class AuthInfoService
{

    public static function isAuth()
    {
        return isset($_SESSION['auth']);
    }

    public static function auth()
    {
        // if (self::auth()) {
        return self::isAuth() ? $_SESSION['auth'] ?? null : null;
        // }
        // return null;
    }
}
