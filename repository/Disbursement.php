<?php

namespace repository;

use libs\APIFetch\Fetch;
use model\Transaction;
use mysql_xdevapi\Exception;

class Disbursement {
    private $serviceUri;
    private $serviceKey;
    private $response;
    function __construct()
    {
        $conf = parse_ini_file('conf.ini');
        if (!isset($conf['FLIP_SECRET']) || !isset($conf['FLIP_API'])) {
            throw new \Exception('FLIP_SECRET and FLIP_API can\'t be null');
        }
        $this->serviceUri = $conf['FLIP_API'];
        $this->serviceKey = $conf['FLIP_SECRET'];
    }

    private function validateResponse() {
        if (property_exists($this->response, 'errors')) {
            throw new \Exception('Error from Flip Service: ' . json_encode($this->response->errors[0]));
        }
    }

    public function store(Transaction $model) {
        $reqData = $model->getData(true);
        $reqData['secret_key'] = $this->serviceKey;

        $fetcher = new Fetch("POST", $this->serviceUri . '/disburse', $reqData);
        $this->response = $fetcher->exec();
        $this->validateResponse();

        $model->status = $this->response->status;
        $model->receipt = $this->response->receipt;
        $model->beneficiary_name = $this->response->beneficiary_name;
        $model->fee = $this->response->fee;
        $model->flip_trans_id = $this->response->id;

        return $model;
    }

    public function fetchOne(Transaction $model) {
        $fetcher = new Fetch(
            "GET",
            $this->serviceUri . '/disburse/' . $model->flip_trans_id,
            [
                'secret_key' => $this->serviceKey
            ]
        );
        $this->response = $fetcher->exec();
        $this->validateResponse();

        $model->status = $this->response->status;
        $model->receipt = $this->response->receipt;
        $model->time_served = $this->response->time_served;

        return $model;
    }
}
