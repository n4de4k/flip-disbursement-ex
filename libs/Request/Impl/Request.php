<?php

namespace libs\Request\Impl;

use libs\Request\iRequest;

class Request implements iRequest {
    private $data = [];

    public function getRequestData($_data, $type) {
        $parsedData = [];
        foreach ($_data as $key => $value) {
            $parsedData[$key] = filter_input($type, $key);
        }

        $this->data = $parsedData;
    }

    public function getData() {
        return $this->data;
    }
}