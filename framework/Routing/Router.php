<?php

namespace Framework\Routing;

use Psr\Http\Message\ServerRequestInterface;

class Router
{
    /**
     * @var Router
     */
    private static $_instance;

    /**
     * @var RouterContainer
     */
    private $routes;

    public function __construct()
    {
        $this->routes = new RouterContainer();
    }

    public function get($uri, $name, $callable)
    {
        $this->routes->addRoute($uri, $name, $callable);
        return $this;
    }

    public function getRoutes(): array
    {
        return $this->routes->getRoutes();
    }

    public function match(ServerRequestInterface $request): ?Route
    {
        foreach ($this->routes->getRoutes() as $route) {
            if ($this->routes->match($request, $route)) {
                return $route;
            }
        }

        return null;
    }

    public static function getInstance(): Router
    {
        if (null === self::$_instance) {
            self::$_instance = new Router();
        }

        return self::$_instance;
    }
}
