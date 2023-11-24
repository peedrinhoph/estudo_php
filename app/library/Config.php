<?php

namespace app\library;

class Config
{

    public static function getEnv()
    {
        return parse_ini_file(dirname(__FILE__, 3) . '/.env');
    }
    
}
