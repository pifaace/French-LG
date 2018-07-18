<?php

namespace Framework\Routing;

use Psr\Http\Message\ServerRequestInterface;

class RouterContainer
{
    /**
     * @var Route[]
     */
    private $routes = [];

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
        $route->setParameters($matches);

        return true;
    }
}
