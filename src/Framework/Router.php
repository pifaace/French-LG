<?php

namespace Framework;

use Aura\Router\Exception\RouteNotFound;
use Aura\Router\Map;
use Aura\Router\RouterContainer;
use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Router
 * Register and match route
 */
class Router
{
    /**
     * @var RouterContainer
     */
    private $routerContainer;

    /**
     * @var Map
     */
    private $map;

    public function __construct()
    {
        $this->routerContainer = new RouterContainer();
        $this->map = $this->routerContainer->getMap();
    }

    /**
     * @param string   $uri
     * @param string   $name
     * @param callable $callable
     * @param array    $token
     */
    public function get(string $uri, string $name, callable $callable, array $token = [])
    {
        $this->map->get($name, $uri, $callable)->tokens($token);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $matcher = $this->routerContainer->getMatcher();
        $result = $matcher->match($request);

        if (!$result) {
            return null;
        }
        return new Route(
            $result->name,
            $result->handler,
            $result->attributes
        );
    }

    public function generateUri(string $name, array $params = []): ?string
    {
        $generator = $this->routerContainer->getGenerator();

        try {
            return $generator->generate($name, $params);
        } catch (RouteNotFound $e) {
            return null;
        }

    }
}
