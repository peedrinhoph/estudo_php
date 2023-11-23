<?php

namespace app\database;

use PDO;

class Connection
{
    private static ?PDO $connection = null;

    public static function connect()
    {
        $database = $_ENV['DB_DATABASE'];
        $user     = $_ENV['DB_USERNAME'];
        $host     = $_ENV['DB_HOST'];
        $password = $_ENV['DB_PASSWORD'];
        if (!self::$connection) {
            self::$connection = new PDO("mysql:host={$host};dbname={$database}", $user, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }

        return self::$connection;
    }
}
