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

    public function parse($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }

    public function validate($validation) {
        foreach ($validation as $key => $value) {
            switch ($value) {
                case 'required': {
                    if (!isset($this->data[$key])) {
                        throw new \Exception($key . ' can\'t be null');
                    }
                    break;
                }
            }
        }
    }
}