<?php

namespace app\core;

use Exception;
use app\library\Log;
use app\enums\EnumLog;
use app\library\LoggerFile;

class Controller
{
    private const NAMESPACE = 'app\\controllers\\';

    private function controllerPath($route, $controller)
    {
        $controllerInstance = $this::NAMESPACE . $controller;

        if ($route->getRouteOptionsInstance() && $route->getRouteOptionsInstance()->optionExist('controller')) {
            $controllerInstance = $this::NAMESPACE . $route->getRouteOptionsInstance()->execute('controller') . '\\' . $controller;
        }

        return $controllerInstance;
    }

    public function call(Route $route)
    {
        $controller = $route->controller;

        if (!str_contains($controller, ':')) {
            throw new Exception("Colon need to controller {$controller} in route");
        }

        [$controller, $action] = explode(':', $controller);

        $controllerInstance = $this->controllerPath($route, $controller);

        // if ($route->getRouteOptionsInstance()->optionExist('controller')) {
        //     $controllerInstance = $this::NAMESPACE . $route->getRouteOptionsInstance()->execute('controller') . '\\' . $controller;
        //     // var_dump($this::NAMESPACE . $route->getRouteOptionsInstance()->execute('controller') . '\\'.$controller);
        // }

        if (!class_exists($controllerInstance)) {
            Log::create(new LoggerFile('logs', "Controller {$controller} does not exis", EnumLog::ControllerNotFound));
            throw new Exception("Controller {$controller} does not exist");
        }


        $controller = new $controllerInstance;

        if (!method_exists($controller, $action)) {
            Log::create(new LoggerFile('logs', "Action {$action} does not exist", EnumLog::ActionNotFound));
            throw new Exception("Action {$action} does not exist");
        }
        call_user_func_array([$controller, $action], []);
    }
}
