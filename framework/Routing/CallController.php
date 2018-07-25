<?php

namespace Framework\Routing;

class CallController
{
    public function __invoke(Route $route)
    {
        $exploded = explode('@', $route->getAction());
        $controllerName = array_shift($exploded);
        $method = end($exploded);

        $controller = new $controllerName;

        return call_user_func_array([$controller, $method], []);
    }
}
