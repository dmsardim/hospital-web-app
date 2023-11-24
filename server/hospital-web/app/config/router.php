<?php

$di->setShared('response', function () {
    $response = new \Phalcon\Http\Response();
    $response->setHeader('Access-Control-Allow-Origin', '*');
    $response->setHeader('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
    $response->setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type');
    return $response;
});

$router = $di->getRouter(); 
$router->handle($_SERVER['REQUEST_URI']);

