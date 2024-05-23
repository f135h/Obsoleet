<?php

namespace Obsoleet;

use \Closure;

class Server
{
    protected $request;
    protected $response;
    protected $routes;
    protected $http_error_callback;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->routes = [];
    }

    public function map($method, $path, $callback) : void
    {
        array_push($this->routes, new Route($method, $path, $callback));
    }

    public function run() : void
    {
        $is_not_found = true;
        foreach ($this->routes as $route)
        {
            if(preg_match('#^' . $route->get_path() . '$#', $this->request->get_path(), $args))
            {
                $is_not_found = false;
                
                if($route->get_method() === $this->request->get_method())
                {
                    $this->response = call_user_func_array($route->get_callback(), [$this->request, $this->response, $args]);
                }
                else
                {
                    $this->response = call_user_func_array($this->http_error_callback, [$this->request, $this->response, ['error_code' => '405']]);
                }
            }
        }

        if ($is_not_found)
        {
            $this->response = call_user_func_array($this->http_error_callback, [$this->request, $this->response, ['error_code' => '404']]);
        }

        echo $this->response->get_output();
        exit(1);
    }

    public function set_http_error_callback(\Closure $callback) : void
    {
        $this->http_error_callback = $callback;
    }
}