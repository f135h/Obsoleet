<?php

namespace Obsoleet;

class Response
{
    protected $headers;
    protected $datas;
    protected $template;

    public function __construct()
    {
        $this->headers = [];
        $this->datas = [];
        $this->template = '';
    }

    public function get_output(bool $minify = false) : string
    {
        ob_start();
        foreach($this->headers as $header)
        {
            header($header);
        }
        foreach($this->datas as $key => $value)
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

    public function get_header(string $name) : string
    {
        return $this->headers[$name];
    }

    public function set_header(string $name, string $value) : void
    {
        $this->headers[$name] = $value;
    }

    public function unset_header(string $name) : void
    {
        unset($this->headers[$name]);
    }

    public function get_data( string $name) : string
    {
        return null === $this->datas[$name] ? '' : $this->datas[$name];
    }

    public function set_data(string $name, mixed $value) : void
    {
        $this->datas[$name] = $value;
    }

    public function unset_data(string $name) : void
    {
        unset($this->datas[$name]);
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