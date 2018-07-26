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
     * @param Route $route
     *
     * @return Route
     */
    public function addRoute(Route $route)
    {
        if (\in_array($route->getUri(), $this->uri, true)) {
            throw DuplicateRouteException::duplicateUri($route->getUri());
        }

        if (array_key_exists($route->getName(), $this->routes)) {
            throw DuplicateRouteException::duplicateUriName($route->getName());
        }

        $this->uri[] = $route->getUri();
        $this->routes[$route->getName()] = $route;

        return $route;
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
        $path = $this->generatePath($route);

        if (!preg_match("#^$path$#i", $uri, $matches)) {
            return false;
        }

        array_shift($matches);
        $route->setParameters($matches);

        return true;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    private function generatePath($route)
    {
        $path = $route->getUri();

        if (!empty($route->getWhere())) {
            foreach ($route->getWhere() as $attribute => $where) {
                $path = preg_replace('#{('.$attribute.')}#', '('.$where.')', $path);
            }
        }
        $path = preg_replace("#{([\w]+)}#", '([^/]+)', $path);

        return $path;
    }
}
