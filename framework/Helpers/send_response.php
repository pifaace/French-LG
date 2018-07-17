<?php

namespace Framework\Helpers;

use Psr\Http\Message\ResponseInterface;

/**
 * Convert Response object to a browser response
 *
 * @param ResponseInterface $response
 */
function send(ResponseInterface $response)
{
    $heading = sprintf('HTTP/%s %s %s',
        $response->getProtocolVersion(),
        $response->getStatusCode(),
        $response->getReasonPhrase());

    header($heading, true, 200);

    foreach ($response->getHeaders() as $key => $header) {
        foreach ($header as $value) {
            header($key . ':' . $value);
        }
    }

    $stream = $response->getBody();

    if ($stream->isWritable()) {
        $stream->rewind();
    }

    while (!$stream->eof()) {
        echo $stream->read(1024 * 8);
    }
}
