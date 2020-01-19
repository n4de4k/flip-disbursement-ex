<?php

namespace controller;

use repository\Transaction as TransactionRepo;

class Transaction {
    private $transactionRepo;

    function __construct() {
        $this->transactionRepo = new TransactionRepo;
    }
}

?>