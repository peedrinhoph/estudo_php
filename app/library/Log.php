<?php

namespace app\library;

use app\interfaces\LoggerInterface;

class Log
{
    public static function create(LoggerInterface $log)
    {
        $log->create();
    }
}
