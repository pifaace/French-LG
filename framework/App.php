<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === '/') {
            return new Response(
                '301',
                ['Location' => substr($uri, 0, -1)],
                ''
            );
        }

        $route = $this->router->match($request);

        if (is_null($route)) {
            return new Response('404', [], 'Error 404');
        }

        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);

        $response = call_user_func_array($route->getCallBack(), [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        }
    }
}
