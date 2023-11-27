<?php

namespace app\library;

use app\database\models\Log;
use app\enums\EnumLog;
use app\interfaces\LoggerInterface;

class LoggerDatabase implements LoggerInterface
{
    public function __construct(private string $name, private string|array $message, private EnumLog $enumLog)
    {
    }

    public function create()
    {
        $type = match ($this->enumLog) {
            $this->enumLog::LoginError => 'Error in login',
            $this->enumLog::DatabaseErrorConnection => 'Connection Error in Database'
        };

        // $message = is_array($this->message) ? json_encode($this->message) : $this->message;
        // $message .= '/' . $type . '/' . date('d/m/Y H:i:s') . '<------------------>';

        $log = new Log;
        $log->create($this->name, json_encode($this->message), $type);

        // var_dump('File log');
    }
}
