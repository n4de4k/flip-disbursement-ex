<?php

namespace libs\Router;

interface iRouter {
    public function get($url, $handler);
    public function post($url, $handler);
    public function handle();
}
