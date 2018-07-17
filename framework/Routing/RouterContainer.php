<?php

namespace Framework\Routing;

use Psr\Http\Message\ServerRequestInterface;

class RouterContainer
{
    /**
     * @var array
     */
    private $routes = [];

    public function addRoute($uri, $name, $callable)
    {
        $this->routes[$uri] = ['name' => $name, 'callable' => $callable];
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function match(ServerRequestInterface $request): ?Route
    {
        $uri = $request->getUri()->getPath();

        if (array_key_exists($uri, $this->routes)) {
            
        }


    }
}
