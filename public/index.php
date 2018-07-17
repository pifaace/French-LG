<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$app = \Framework\App::getInstance();

$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

Framework\Helpers\send($response);
