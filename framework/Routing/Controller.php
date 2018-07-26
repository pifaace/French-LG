<?php

namespace Framework\Routing;

class Controller
{
    public function callAction(Route $route)
    {
        $exploded = explode('@', $route->getAction());
        $controllerName = array_shift($exploded);
        $method = end($exploded);

        $controller = new $controllerName();

        return call_user_func_array([$controller, $method], []);
    }

    public function __call($name, $arguments)
    {
        throw new \BadMethodCallException(sprintf(
            "Method %s does not exist in %s", $name, static::class)
        );
    }
}
