<?php

namespace App\Controller;

use GuzzleHttp\Psr7\Response;

class IndexController
{
    public function index()
    {
        return new Response(200, [], 'Hello from index');
    }
}
