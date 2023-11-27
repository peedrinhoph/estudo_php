<?php

namespace app\library;

use app\enums\EnumLog;
use app\interfaces\LoggerInterface;

readonly class LoggerFile implements LoggerInterface
{

    public function __construct(private string $name, private string|array $message, private EnumLog $enumLog)
    {
    }

    public function create()
    {
        // $type = match($this->enumLog){
        //     $this->enumLog::LoginError => 'Error in login',
        //     $this->enumLog::DatabaseErrorConnection => 'Connection Error in Database'
        // };

        $messageError = is_array($this->message) ? json_encode($this->message) : $this->message;
        $message = date('d/m/Y H:i:s') . ' (' . $this->enumLog->value . ') ' . $messageError . PHP_EOL;

        file_put_contents(dirname(__FILE__, 2) . '/storage/logs/' . $this->name . '.txt', $message, FILE_APPEND | LOCK_EX);
    }
}
