<?php

namespace app\database\models;

use app\database\Connection;

class Log extends Model
{
    public function create(string $name, string $message, string $type)
    {
        $con = Connection::connect();
        $prepare = $con->prepare("insert into logs(message, type) values (:message, :type)");

        return $prepare->execute([
            'message' => $message,
            'type' => $type
        ]);
    }
}
