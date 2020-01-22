<?php

namespace libs\APIFetch;

class Fetch {
    public $curl;
    function __construct($method, $url, $data = []) {
        $this->curl = curl_init();

//        var_dump(count($data));
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        switch ($method) {
            case 'POST' : {
                curl_setopt($this->curl, CURLOPT_POST, 1);
                if (count($data) > 0) {
                    curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($data));
                }
                break;
            }
            case 'GET': {
                if (count($data)) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
                break;
            }
        }

        if (isset($data['secret_key'])) {
            curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($this->curl, CURLOPT_USERNAME, $data['secret_key']);

            unset($data['secret_key']);
        }

        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    }

    public function exec($responseType = 'json') {
        $result = curl_exec($this->curl);
        curl_close($this->curl);

        switch ($responseType) {
            case 'json': {
                try {
                    return json_decode($result);
                } catch (\Exception $e) {
                    throw new \Exception('Fail to get valid response from flip: ', $e->getMessage());
                }
                break;
            }
            default: {
                throw new \Exception('Response Type ' . $responseType . ' not implemented yet.');
            }
        }
    }
}