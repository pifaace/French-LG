<?php

namespace Tests\framework\Routing;

use Framework\Facades\Route;
use Framework\Routing\Router;
use Grpc\Server;
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
        Route::get('/profile', 'profile', function () {return 'profile';});
    }

    public function testRegisterRoute()
    {
        $router = Router::getInstance();
        $this->assertCount(3, $router->getRoutes());
    }

    public function testGetMethodWithNoParameter()
    {
        $request = new ServerRequest('GET', '/index');
        $route = $this->router->match($request);

        $this->assertEquals('index', $route->getName());
        $this->assertEquals('hello from index', call_user_func_array($route->getCallBack(), [$request]));
    }
}
