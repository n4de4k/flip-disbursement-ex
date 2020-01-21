<?php

namespace libs\Controller;

class Controller {
    public function json($data = [], $code = 200) {
        header("Content-type:application/json;charset=utf-8");

        try {
            $result = json_encode($data);

            http_response_code($code);
            echo $result;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                "message" => "Invalid response format: " . $e->getMessage()
            ]);
        }
    }
}