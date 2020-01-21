<?php

spl_autoload_register(function ($class_name) {
    try {
        $name = str_replace('\\', '/', $class_name);
        include_once __DIR__ . '/' .$name . '.php';
    } catch (Exception $e) {
        throw new Exception("Unable to load $class_name. Error: " . $e);
    }
});

use libs\Request\Impl\Request;
use libs\Router\Impl\Router;

try {
    $request = new Request();
    $router = new Router($request);
    $router->get('/test', 'Transaction::newTransaction');

    $router->handle();
} catch (Exception $e) {
    var_dump($e);
}

