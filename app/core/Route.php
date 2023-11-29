<?php

namespace app\core;

use app\library\Uri;
use app\library\RouteOptions;
use app\library\RouteWildcard;

class Route
{
    private ?RouteOptions $routeOptions = null;
    private ?Uri $uri = null;
    private ?RouteWildcard $wildcard = null;

    public function __construct(
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

    public function addRouteUri(Uri $uri)
    {
        $this->uri = $uri;
    }

    public function getRouteUriInstance(): ?Uri
    {
        return $this->uri;
    }

    public function addRouteWildcard(RouteWildcard $wildcard)
    {
        $this->wildcard = $wildcard;
    }

    public function getRouteWildcardInstance(): ?RouteWildcard
    {
        return $this->wildcard;
    }

    public function match()
    {

        if ($this->routeOptions->optionExist(('prefix'))) {
            $this->uri->setUri(rtrim("/{$this->routeOptions->execute('prefix')}{$this->uri->getUri()}", '/'));
            // var_dump($this->uri);
        }

        $this->wildcard->replaceWildcardWithPattern($this->uri->getUri());
        $wildcardReplaced = $this->wildcard->getWildcardReplaced();

        if ($wildcardReplaced != $this->uri->getUri() && $this->wildcard->uriEqualToPattern($this->uri->currentUri(), $wildcardReplaced)) {
            $this->uri->setUri($this->uri->currentUri());
        }

        if ($this->uri->getUri() === $this->uri->currentUri() && strtolower($this->request) === $this->uri->currentRequest()) {
            return $this;
        }
    }
}
