<?php

include_once(dirname(__FILE__) . '/src/autoloader.php');

use Obsoleet\Response,
    Obsoleet\Request;

$server = new Obsoleet\Server();

$server->map('GET', '/', function (Request $req, Response $res, array $args) : Response {
    $res->set_http_status('200');
    $res->set_template(dirname(__FILE__) . '/src/templates/test.php');
    $res->push_data('title', 'Titre!');
    $res->push_data('nav', ['one', 'two', 'three', 'four', 'five']);
    return $res;
});

$server->set_http_error_callback(function (Request $req, Response $res, array $args) : Response {
    $res->set_http_status($args['error_code']);
    $res->set_template(dirname(__FILE__) . '/src/templates/error.php');
    $res->push_data('title', $args['error_code']);
    $res->push_data('message', 'Oups! C\'est une erreur.');
    return $res;
});

$server->run();