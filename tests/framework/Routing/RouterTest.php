<?php

namespace Tests\framework\Routing;

use Framework\Facades\Route;
use Framework\Routing\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private $router;

    public function setUp()
    {
        $this->router = Router::getInstance();

        Route::get('/', 'index', function () {return 'hello from index';});
        Route::get('/contact', 'contact', function () {return 'contact';});
        Route::get('/profile/{id}', 'profile', function ($id) {return 'profile ' . $id;});
    }

    public function testRegisterRoute()
    {
        $this->assertCount(3, $this->router->getRoutes());
    }

    public function testGetMethodWithNoParameter()
    {
        $request = new ServerRequest('GET', '/');
        $route = $this->router->match($request);

        $this->assertEquals('index', $route->getName());
        $this->assertEquals('hello from index', \call_user_func_array($route->getCallable(), []));
    }

    public function testGetWithParameters()
    {
        $request = new ServerRequest('GET', '/profile/3');
        $route = $this->router->match($request);

        $this->assertEquals('profile', $route->getName());
        $this->assertEquals('profile 3', \call_user_func_array($route->getCallable(), $route->getParameters()));
    }

    public function testInvalidRoute()
    {
        $request = new ServerRequest('GET', '/ferfeffe');
        $response = $this->router->match($request);

        $this->assertEquals(null, $response);
    }
}
