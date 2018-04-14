<?php

namespace Tests\Framework;

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/login/');
        $response = $app->run($request);
        $this->assertContains('/login', $response->getHeader('Location'));
        $this->assertEquals('301', $response->getStatusCode());
    }

    public function testBlog()
    {
        $app = new App([
                BlogModule::class
            ]
        );
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        $this->assertContains('<h1>Bienvenu sur le blog</h1>', (string)$response->getBody());
        $this->assertEquals('200', $response->getStatusCode());

        $requestSingle = new ServerRequest('GET', '/blog/article-de-test');
        $responseSingle = $app->run($requestSingle);
        $this->assertContains('<h1>Bienvenu sur l\'article article-de-test</h1>', (string)$responseSingle->getBody());
        $this->assertEquals('200', $responseSingle->getStatusCode());

    }

    public function testError404()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/ceded');
        $response = $app->run($request);
        $this->assertContains('Error 404', (string)$response->getBody());
        $this->assertEquals('404', $response->getStatusCode());
    }
}
