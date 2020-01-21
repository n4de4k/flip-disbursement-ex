<?php

namespace controller;

use libs\Controller\Controller;
use repository\Transaction as TransactionRepo;
use libs\Request\iRequest;

class Transaction extends Controller {
    private $transactionRepo;

    function __construct() {
        $this->transactionRepo = new TransactionRepo;
    }

    public function newTransaction(iRequest $request) {
        $this->json($request->getData(), 200);
    }
}
