<?php

namespace controller;

use libs\Controller\Controller;
use repository\Transaction as TransactionRepo;
use repository\Disbursement as DisburseMentRepo;
use model\Transaction as TransactionModel;
use libs\Request\iRequest;

class Transaction extends Controller {
    private $transactionRepo;
    private $disbursementRepo;

    function __construct() {
        $this->transactionRepo = new TransactionRepo;
        $this->disbursementRepo = new DisburseMentRepo;
    }

    public function newTransaction(iRequest $request) {
        $request->validate([
            "bank_code" => "required",
            "account_number" => "required",
            "amount" => "required",
            "remark" => "required"
        ]);
        $trans = new TransactionModel();
        $trans->bank_code = $request->parse('bank_code');
        $trans->account_number = $request->parse('account_number');
        $trans->amount = $request->parse('amount');
        $trans->remark = $request->parse('remark');

        $trans = $this->disbursementRepo->store($trans);

        $this->transactionRepo->store($trans);
        $this->json($trans->getData(), 200);
    }

    public function checkTransaction(iRequest $request) {
        $request->validate([
            "id_transaction" => 'required'
        ]);

        $trans = new TransactionModel();
        $trans->id = $request->parse('id_transaction');

        $trans = $this->transactionRepo->get($trans);

        $trans = $this->disbursementRepo->fetchOne($trans);

        $trans = $this->transactionRepo->updateOne($trans);
        $this->json($trans->getData(), 200);
    }
}
