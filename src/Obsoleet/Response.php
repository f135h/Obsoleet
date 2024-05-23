<?php

namespace Obsoleet;

class Response
{
    public function __construct()
    {
    }

    protected function getOutput(string $template, array $data, bool $minify = true) : string
    {
        ob_start();
        foreach($data as $key => $value){ $$key = $value; }
        include_once($template);
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
}