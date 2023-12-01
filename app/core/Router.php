<?php

namespace app\core;

use Closure;
use app\library\Redirect;
use app\library\RouteOptions;
use app\library\RouteWildcard;
use app\library\Uri;

class Router
{
    private array $routes = [];
    private array $routeOptions = [];
    private Route $route;

    public function add(
        string $uri,
        string $request,
        string $controller,
        array  $routeAliases = []
    ) {
        $this->route = new Route($request, $controller, $routeAliases);
        $this->route->addRouteUri(new Uri($uri));
        $this->route->addRouteWildcard(new RouteWildcard);
        $this->route->addRouteGroupOptions(new RouteOptions($this->routeOptions));

        $this->routes[] = $this->route;

        return $this;
    }

    public function middleware(array $middlewares)
    {
        // var_dump(['middlewares' => $middlewares]);
        $options = [];
        if (!empty($this->routeOptions)) {
            $options = array_merge($this->routeOptions, ['middlewares' => $middlewares]);
        }
        $this->route->addRouteGroupOptions(new RouteOptions($options));
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

        return (new Controller)->call(new Route('GET', 'NotFoundController:index', []));
    }
}
