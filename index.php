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
use app\App;

try {
    $request = new Request();
    $router = new Router($request);

    $app = new App($router);
    $app->run();
} catch (Exception $e) {
    header("Content-type:application/json;charset=utf-8");
    http_response_code(500);
    echo json_encode([
        "code"=> 500,
        "message"=> $e->getMessage(),
        "stack" => $e->getTrace()
    ]);
}

