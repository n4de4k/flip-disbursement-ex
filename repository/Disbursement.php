<?php

namespace repository;

use libs\APIFetch\Fetch;
use model\Transaction;

class Disbursement {
    private $serviceUri;
    private $serviceKey;
    function __construct()
    {
        $conf = parse_ini_file('conf.ini');
        if (!isset($conf['FLIP_SECRET']) || !isset($conf['FLIP_API'])) {
            throw new \Exception('FLIP_SECRET and FLIP_API can\'t be null');
        }
        $this->serviceUri = $conf['FLIP_API'];
        $this->serviceKey = $conf['FLIP_SECRET'];
    }

    public function store(Transaction $model) {
        $reqData = $model->getData(true);
        $reqData['secret_key'] = $this->serviceKey;

        $fetcher = new Fetch("POST", $this->serviceUri . '/disburse', $reqData);
        $response = $fetcher->exec();

        $model->status = $response['status'];
        $model->receipt = $response['receipt'];
        $model->time_served = $response['time_serve'];
        $model->beneficiary_name = $response['beneficiary_name'];
        $model->fee = $response['fee'];

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
        $response = $fetcher->exec();

        $model->status = $response['status'];
        $model->receipt = $response['receipt'];
        $model->time_served = $response['time_serve'];

        return $model;
    }
}
