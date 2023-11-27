<?php

namespace app\enums;

use Exception;
use app\library\Config;

enum Environment
{
    case Development;
    case Production;

    public function getEnvironment()
    {
        $ENV = Config::getEnv();
        
        if (!isset($ENV) || empty($ENV)) {
            throw new Exception("Arquivo .env não encontrado.");
        }

        return match ($this) {
            self::Development => $ENV['APP_ENV'],
            self::Production => $ENV['APP_ENV']
        };
    }
}
