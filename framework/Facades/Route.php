<?php

namespace Framework\Facades;

use Framework\Routing\Router;

class Route
{
    public static function __callStatic($method, $arguments)
    {
        return \call_user_func_array([Router::getInstance(), $method], $arguments);
    }
}
