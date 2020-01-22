<?php

namespace libs\Request;

interface iRequest {
    public function getRequestData($_data, $type);
    public function parse($key);
}