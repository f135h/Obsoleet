<?php

namespace Obsoleet;

use \Closure;

class Route
{
    protected $method;
    protected $handler;
    protected $path;

    public function __construct(string $method, string $path, Closure $handler)
    {
        $this->method = strtolower($method);
        $this->handler = $handler;
        $this->path = $path;
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getHandler() : Closure
    {
        return $this->handler;
    }
}