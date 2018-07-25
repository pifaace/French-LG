<?php

namespace Framework\Routing;

use Psr\Http\Message\ServerRequestInterface;

class Router
{
    /**
     * @var Router instance
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

    /**
     * Register a GET route.
     *
     * @param $uri
     * @param $name
     * @param $action
     * @return Route
     */
    public function get($uri, $name, $action): Route
    {
        return $this->routes->addRoute($this->createRoute($uri, $name, $action));
    }

    /**
     * Create a new route
     *
     * @param $uri
     * @param $name
     * @param $action
     * @return Route
     */
    private function createRoute($uri, $name, $action): Route
    {
        if (\is_string($action)) {
            $action = $this->convertToControllerAction($action);
        }

        return new Route($uri, $name, $action);
    }

    private function convertToControllerAction($action): string
    {
        $action = 'App\\Controller\\'.$action;
        return $action;
    }

    /**
     * Return an array of all routes.
     *
     * @return Route[]
     */
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

    /**
     * Return an unique instance of Router.
     *
     * @return Router
     */
    public static function getInstance(): Router
    {
        if (null === self::$_instance) {
            self::$_instance = new Router();
        }

        return self::$_instance;
    }
}
