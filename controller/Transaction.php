<?php

namespace controller;

use libs\Controller\Controller;
use repository\Transaction as TransactionRepo;
use model\Transaction as TransactionModel;
use libs\Request\iRequest;

class Transaction extends Controller {
    private $transactionRepo;

    function __construct() {
        $this->transactionRepo = new TransactionRepo;
    }

    public function newTransaction(iRequest $request) {
        $trans = new TransactionModel();
        $trans->bank_code = $request->parse('bank_code');
        $trans->account_number = $request->parse('account_number');
        $trans->amount = $request->parse('amount');
        $trans->remark = $request->parse('remark');

        $this->transactionRepo->store($trans);
        $this->json($trans->getData(), 200);
    }
}
