<?php

namespace App\Blog;

use Framework\Router;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogModule
{
    public function __construct(Router $router)
    {
        $router->get('/blog', 'blog.index', [$this, 'index']);
        $router->get('/blog/{slug}', 'blog.show', [$this, 'show'], [
            'slug' => '[a-z\-]+'
        ]);
    }

    public function index(Request $request)
    {
        return "<h1>Bienvenu sur le blog</h1>";
    }

    public function show(Request $request)
    {
        return "<h1>Bienvenu sur l'article " . $request->getAttribute('slug') . "</h1>";
    }
}
