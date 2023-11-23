<?php

namespace app\database;

use PDO;

class Connection
{
    private static ?PDO $connection = null;

    public static function connect()
    {

        $database = "homestead"; //$_ENV['DB_DATABASE'];
        $user     = "root"; //$_ENV['DB_USERNAME'];
        $host     = "172.23.0.1";//$_ENV['DB_HOST'];
        $password = "secret"; //$_ENV['DB_PASSWORD'];
        if (!self::$connection) {
            self::$connection = new PDO("mysql:host={$host};dbname={$database}", $user, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }

        return self::$connection;
    }
}
