<?php

namespace Framework\Routing;

use Framework\Routing\Exceptions\DuplicateRouteException;
use Psr\Http\Message\ServerRequestInterface;

class RouterContainer
{
    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * @var array
     */
    private $uri = [];

    /**
     * @param $uri
     * @param $name
     * @param $callable
     */
    public function addRoute($uri, $name, $callable): void
    {
        if (\in_array($uri, $this->uri, true)) {
            throw DuplicateRouteException::duplicateUri($uri);
        }

        if (array_key_exists($name, $this->routes)) {
            throw DuplicateRouteException::duplicateUriName($name);
        }

        $this->uri[] = $uri;
        $this->routes[$name] = new Route($uri, $name, $callable);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Check if the current object route is matching the request route.
     *
     * @param ServerRequestInterface $request
     * @param Route                  $route
     *
     * @return bool
     */
    public function match(ServerRequestInterface $request, Route $route): bool
    {
        $uri = $request->getUri()->getPath();

        $path = preg_replace("#{([\w]+)}#", '([^/]+)', $route->getUri());

        if (!preg_match("#^$path$#i", $uri, $matches)) {
            return false;
        }

        array_shift($matches);
        $route->setParameters($matches);

        return true;
    }
}
