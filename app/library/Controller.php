<?php

namespace app\library;

use Exception;

class Controller
{
    // private const NAMESPACE = 'app\\controllers\\';
    public function call(Route $route)
    {
        $controller = $route->controller;
        if (!str_contains($controller, ':')) {
            throw new Exception("Separação do controller {$controller} na rota não corresponde");
        }
        
        [$controller, $action] = explode(':', $controller);
        
        $controllerInstance = "app\\controllers\\" . $controller;
        
        if (!class_exists($controllerInstance)) {
            throw new Exception("Controller {$controller} não existe");
        }
        // var_dump($controller." chamando o metodo ".$action );
        
        $controller = new $controllerInstance;

        if (!method_exists($controller, $action)) {
            throw new Exception("Ação {$action} não existe");
        }

        // $controller->$action();
        call_user_func_array([$controller, $action], []);
    }
}
