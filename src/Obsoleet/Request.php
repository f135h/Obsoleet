<?php

namespace Obsoleet;

class Request
{
    protected $path;
    protected $method;

    public function __construct(string $path, string $method)
    {
        $this->path = $path;
        $this->method = strtolower($method);
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getMethod() : string
    {
        return $this->method;
    }
}