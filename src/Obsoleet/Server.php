<?php

namespace Obsoleet;

class Server
{
    protected $request;
    protected $response;
    protected $routes;
    protected $template_dir;

    public function __construct()
    {
        $this->request = new Request(
            $this->filterPath(),
            $this->filterMethod()
        );
        $this->response = new Response();
        $this->routes = [];
    }

    public function map($method, $path, $callback) : void
    {
        array_push($this->routes, new Route($method, $path, $callback));
    }

    public function run() : void
    {
        foreach ($this->routes as $route)
        {
            if(preg_match('#^' . $route->getPath() . '$#', $this->request->getPath(), $args))
            {
                if($route->getMethod() === $this->request->getMethod())
                {
                    $this->response = call_user_func_array($route->getHandler(), [$this->request, $this->response, $args]);
                }
                else
                {
                    #405;
                }
            }
        }
        #404
        exit(1);
    }

    protected function filterPath() : string
    {
        return parse_url('http://domain.tld' . filter_input(INPUT_SERVER, 'REQUEST_URI'), PHP_URL_PATH);
    }

    protected function filterQuery() : string
    {
        $qry = filter_input(INPUT_SERVER, 'QUERY_STRING');
        return null === $qry ? '' : $qry;
    }

    protected function filterMethod() : string
    {
        $mtd = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        return null === $mtd ? '' : $mtd;
    }
}