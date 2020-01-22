<?php

spl_autoload_register(function ($class_name) {
    try {
        $name = str_replace('\\', '/', $class_name);
        include_once __DIR__ . '/' .$name . '.php';
    } catch (Exception $e) {
        throw new Exception("Unable to load $class_name. Error: " . $e);
    }
});

use model\Transaction;

$trans = new Transaction();
$trans->flip_trans_id = 1;
$trans->bank_code = '22132';
$trans->account_number = '122412323';
$trans->amount = 1000000;
$trans->remark = "sample";

use repository\Disbursement;
$disb = new Disbursement();
$disb->fetchOne($trans);