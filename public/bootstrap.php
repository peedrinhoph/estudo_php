<?php

use app\core\Router;
use app\enums\Environment;

require '../vendor/autoload.php';

session_start();

// $dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
// $dotenv->load();

$router = new Router;

if (Environment::Production->getEnvironment()) {
    ini_set('display_erros', 0);
    ini_set('display_startup_erros', 0);
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}
