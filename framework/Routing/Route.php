<?php

namespace Framework\Routing;

/**
 * Represent a register route
 */
class Route
{
    private $name;

    private $callable;

    private $uri;

    public function __construct($uri, $name, $callable)
    {
        $this->name = $name;
        $this->callable = $callable;
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallable(): callable
    {
        return $this->callable;
    }
}
