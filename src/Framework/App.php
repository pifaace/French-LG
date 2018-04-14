<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * @var array
     */
    private $modules;

    /**
     * App constructor.
     * @param string[] $modules Modules list to load
     */
    public function __construct(array $modules = [])
    {
        $router = new Router();
        foreach ($modules as $module) {
            $this->modules[] = new $module();
        }
    }

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

        if ($uri === '/blog') {
            return new Response('200', [], '<h1>Bienvenue sur le blog</h1>');
        }

        return new Response('404', [], 'Error 404');
    }
}
