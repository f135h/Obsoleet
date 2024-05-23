<?php

namespace Obsoleet;

class Response
{
    protected $data;
    protected $template;
    protected $headers;
    protected $http_status_header;
    protected $http_status_codes;

    public function __construct()
    {
        $this->data = [];
        $this->template = '';
        $this->headers = [];
        $this->http_status_codes = json_decode(file_get_contents(dirname(__DIR__, 1) . '/http_status_codes.json'), true);
    }

    public function get_output(bool $minify = true) : string
    {
        ob_start();
        header($this->http_status_header);
        foreach($this->headers as $header)
        {
            header($header);
        }
        foreach($this->data as $key => $value)
        {
            $$key = $value;
        }
        include_once($this->template);
        $output = ob_get_clean();
        if($minify)
        {
            $output = preg_replace(
                ['/(\n|^)(\x20+|\t)/', '/(\n|^)\/\/(.*?)(\n|$)/', '/\n/', '/\<\!--.*?-->/', '/(\x20+|\t)/', '/\>\s+\</', '/(\"|\')\s+\>/', '/=\s+(\"|\')/'],
                ["\n", "\n", " ", "", " ", "><", "$1>", "=$1"],
                $output
            );
        }
        return $output;
    }

    public function set_http_status(string $code) : void
    {
        $this->http_status_header = 'HTTP/2' . ' ' . $this->http_status_codes[$code]['code'] . ' ' . $this->http_status_codes[$code]['message']; 
    }

    public function get_data( string $name) : string
    {
        return null === $this->data[$name] ? '' : $this->data[$name];
    }

    public function push_data($name, $value) : void
    {
        $this->data[$name] = $value;
    }

    public function get_template() : string
    {
        return $this->template;
    }

    public function set_template(string $template) : void
    {
        $this->template = $template;
    }
}