<?php

namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function testGetMethod()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blog', 'blog', function () {return 'hello';});
        $route = $this->router->match($request);

        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallBack(), [$request]));
    }

    public function testGetMethodIfUrlDoesNotExists()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blogjbj', 'blog', function () {return 'hello';});
        $route = $this->router->match($request);

        $this->assertEquals(null, $route);
    }

    public function testGetMethodWithParameters()
    {
        $request = new ServerRequest('GET', '/blog/mon-slug-8');
        $this->router->get('/blog', 'posts', function () {return 'pashello';});
        $this->router->get('/blog/{slug}-{id}', 'post.show', function () {return 'hello';});
        $route = $this->router->match($request);

        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals(['slug' => 'mon-slug', 'id' => '8'], $route->getParams());
    }

    public function testGenerateUri()
    {
        $this->router->get('/blog/faq', 'posts', function () {return 'pashello';});
        $this->router->get('/blog/{slug}-{id}', 'post.show', function () {return 'hello';});
        $uri = $this->router->generateUri('posts');
        $uriWithParams = $this->router->generateUri('post.show', ['slug' => 'mon-slug', 'id' => '18']);
        $this->assertEquals('/blog/faq', $uri);
        $this->assertEquals('/blog/mon-slug-18', $uriWithParams);

        //Fail to generateUri on known route
        $knownUri = $this->router->generateUri('known');
        $this->assertEquals(null, $knownUri);
    }
}
