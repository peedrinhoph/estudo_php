<?php

namespace app\core;

use Closure;
use app\library\Redirect;
use app\library\RouteOptions;

class Router
{
    private array $routes = [];
    private array $routeOptions = [];

    public function add(
        string $uri,
        string $request,
        string $controller
    ) {
        $route = new Route($uri, $request, $controller);
        $route->addRouteGroupOptions(new RouteOptions($this->routeOptions));

        $this->routes[] = $route;
    }

    public function group(array $routeGroupOptions, Closure $callback)
    {
        $this->routeOptions = $routeGroupOptions;
        $callback->call($this);
        $this->routeOptions = [];
    }

    public function init()
    {
         
        foreach ($this->routes as $route) {
            if ($route->match()) {
                Redirect::register($route);
                return (new Controller)->call($route);
            }
        }

        return (new Controller)->call(new Route('/404', 'GET', 'NotFoundController:index'));
    }
}
