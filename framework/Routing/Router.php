<?php

namespace Framework\Routing;

use Psr\Http\Message\ServerRequestInterface;

class Router
{
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

    public function match(ServerRequestInterface $request)
    {
        $result = $this->routes->match($request);
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new Router();
        }

        return self::$_instance;
    }
}
