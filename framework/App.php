<?php

namespace Framework;

use Framework\Routing\Controller;
use Framework\Routing\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    private static $_instance;

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $router = Router::getInstance();
        $route = $router->match($request);

        if (null === $route) {
            return new Response(404, [], '404 not found');
        }

        if (!\is_callable($route->getAction())) {
            $controller = new Controller();
            return $controller->callAction($route);
        }

        $response = \call_user_func_array($route->getAction(), $route->getParameters());

        return new Response(200, [], $response);
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }
}
