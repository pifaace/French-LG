<?php

namespace Framework;

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
        $router->match($request);

        return new Response(200, [], 'test');
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }
}
