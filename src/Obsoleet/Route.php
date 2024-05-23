<?php

namespace Obsoleet;

use \Closure;

class Route
{
    protected $method;
    protected $callback;
    protected $path;

    public function __construct(string $method, string $path, Closure $callback)
    {
        $this->method = strtolower($method);
        $this->callback = $callback;
        $this->path = $path;
    }

    public function get_method() : string
    {
        return $this->method;
    }

    public function get_path() : string
    {
        return $this->path;
    }

    public function get_callback() : Closure
    {
        return $this->callback;
    }
}