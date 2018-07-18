<?php

namespace Framework\Routing;

use Psr\Http\Message\ServerRequestInterface;

class RouterContainer
{
    /**
     * @var Route[]
     */
    private $routes = [];

    private $match;

    public function addRoute($uri, $name, $callable): void
    {
        $this->routes[$name] = new Route($uri, $name, $callable);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function match(ServerRequestInterface $request, Route $route): bool
    {
        $uri = $request->getUri()->getPath();

        $path = preg_replace("#{([\w]+)}#", '([^/]+)', $route->getUri());

        if (!preg_match("#^$path$#i", $uri, $matches)) {
            return false;
        }

        array_shift($matches);
        $this->match = $matches;

        return true;
    }

    public function call(Route $route)
    {
        return \call_user_func_array($route->getCallable(), $this->match);
    }
}
