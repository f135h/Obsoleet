<?php

namespace Obsoleet;

class Request
{
    protected $path;
    protected $method;

    public function __construct()
    {
        $this->path = $this->filter_path();
        $this->method = $this->filter_method();
    }

    protected function filter_path() : string
    {
        return parse_url('http://domain.tld' . filter_input(INPUT_SERVER, 'REQUEST_URI'), PHP_URL_PATH);
    }

    protected function filter_query() : string
    {
        $qry = filter_input(INPUT_SERVER, 'QUERY_STRING');
        return null === $qry ? '' : $qry;
    }

    protected function filter_method() : string
    {
        $mtd = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        return null === $mtd ? '' : strtolower($mtd);
    }

    public function get_path() : string
    {
        return $this->path;
    }

    public function get_method() : string
    {
        return $this->method;
    }
}