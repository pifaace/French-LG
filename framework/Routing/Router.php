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
     *
     * @return Route
     */
    public function get($uri, $name, $action): Route
    {
        return $this->routes->addRoute($this->createRoute(['GET'], $uri, $name, $action));
    }

    /**
     * Create a new route.
     *
     * @param $method
     * @param $uri
     * @param $name
     * @param $action
     *
     * @return Route
     */
    private function createRoute($method, $uri, $name, $action): Route
    {
        if (\is_string($action)) {
            $action = $this->convertToControllerAction($action);
        }

        return new Route($method, $uri, $name, $action);
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
    public function getAllRoutes(): array
    {
        return $this->routes->getAllRoutes();
    }

    public function match(ServerRequestInterface $request): ?Route
    {
        // At first we need ton determine which type of method is called
        $method = $request->getMethod();

        foreach ($this->routes->getRoutesForSpecificMethod($method) as $route) {
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
