<?php

namespace App\Controller;

use Framework\Routing\Controller;
use GuzzleHttp\Psr7\Response;

class IndexController extends Controller
{
    public function index()
    {
        return new Response(200, [], 'Hello from index');
    }

    public function user($id, $foo)
    {
        return new Response(200, [], 'User '.$id . $foo);
    }
}
