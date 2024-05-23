<?php

include_once(dirname(__FILE__) . '/src/autoloader.php');

use Obsoleet\Response,
    Obsoleet\Request;

$server = new Obsoleet\Server();

$server->map('GET', '/([0-9]+?)', function (Request $req, Response $res, array $args) : Response {
    var_dump($args);
    return $res;
});

$server->run();