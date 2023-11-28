<?php

namespace app\core;

use app\library\RouteOptions;

class Route
{
    private ?RouteOptions $routeOptions = null;

    public function __construct(
        public string $uri,
        public string $request,
        public string $controller,
    ) {
    }

    public function addRouteGroupOptions(RouteOptions $routeOptions)
    {
        $this->routeOptions = $routeOptions;
    }

    public function getRouteOptionsInstance(): ?RouteOptions
    {
        return $this->routeOptions;
    }

    private function currentUri()
    {
        return $_SERVER['REQUEST_URI'] !== '/' ? rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') : '/';
    }

    private function currentRequest()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function match()
    {

        if($this->routeOptions->optionExist(('prefix'))){
            $this->uri = rtrim("/{$this->routeOptions->execute('prefix')}{$this->uri}", '/');
            // var_dump($this->uri);
        }

        if (
            $this->uri === $this->currentUri() &&
            strtolower($this->request) === $this->currentRequest()
        ) {
            return $this;
        }
    }
}
