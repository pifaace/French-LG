<?php

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';
require dirname(__DIR__) . '/config/routes.php';

$app = \Framework\App::getInstance();
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

Framework\Helpers\send($response);
