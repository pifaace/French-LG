<?php

namespace Framework\Routing;

/**
 * Represent a register route
 */
class Route
{
    private $name;

    private $callable;

    public function __construct($name, $callable)
    {
        $this->name = $name;
        $this->callable = $callable;
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
