<?php

namespace Framework\Routing;

/**
 * Represent a register route.
 */
class Route
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable|string
     */
    private $callable;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var array
     */
    private $wheres = [];

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

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = array_merge($this->parameters, $parameters);
    }

    public function where($expressions)
    {
        $this->wheres = array_merge($this->wheres, $expressions);

        return $this;
    }

    public function getWhere()
    {
        return $this->wheres;
    }
}
