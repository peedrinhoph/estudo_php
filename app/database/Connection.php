<?php

namespace app\database;

use PDO;
use app\library\Config;

class Connection
{
    private static ?PDO $connection = null;

    public static function connect()
    {
        $ENV = Config::getEnv();
        
        $database = $ENV['DB_DATABASE'];
        $user     = $ENV['DB_USERNAME'];
        $host     = $ENV['DB_HOST'];
        $password = $ENV['DB_PASSWORD'];
        
        if (!self::$connection) {
            self::$connection = new PDO("mysql:host={$host};dbname={$database}", $user, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }

        return self::$connection;
    }
}
