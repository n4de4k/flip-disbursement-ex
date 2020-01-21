<?php

namespace libs\Router\Impl;

use libs\Router\iRouter;
use libs\Request\iRequest;

class Router implements iRouter{
    private $request;
    private $mapGetRoute = [];
    private $mapPostRoute = [];

    function __construct(iRequest $_request) {
        $this->request = $_request;
    }

    private function findSuitHandler($route, $maps) {
        foreach ($maps as $key => $handler) {
            if ($key == $route) {
                return $handler;
            }
        }

        throw new \Exception('404 Not Found');
    }

    private function getRequestPath()
    {
        $request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $script_name = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
        $parts = array_diff_assoc($request_uri, $script_name);
        if (empty($parts))
        {
            return '/';
        }
        $path = implode('/', $parts);
        if (($position = strpos($path, '?')) !== FALSE)
        {
            $path = substr($path, 0, $position);
        }

        return '/' . $path;
    }

    public function handle() {
        $reqMethod = $_SERVER['REQUEST_METHOD'];

        $handler = "";
        try {
            switch ($reqMethod) {
                case 'GET': {
                    $handler = $this->findSuitHandler($this->getRequestPath(), $this->mapGetRoute);
                    break;
                }
                case 'POST': {
                    $handler = $this->findSuitHandler($this->getRequestPath(), $this->mapPostRoute);
                    break;
                }
            }
        } catch (\Exception $e) {
            http_response_code(404);
            echo $e->getMessage();

            return;
        }
        $this->request->getRequestData($_GET, INPUT_GET);

        $handlerInformation = explode('::', $handler);
        if (count($handlerInformation) !== 2) {
            throw new \Exception("Wrong handler");
        }

        $controllerName = 'controller\\' . $handlerInformation[0];
        $controller = new $controllerName();
        $methodName = $handlerInformation[1];

        $controller->$methodName($this->request);
    }

    public function get($url, $handler) {
        $this->mapGetRoute[$url] = $handler;
    }

    public function post($url, $handler) {
        $this->mapPostRoute[$url] = $handler;
    }
}