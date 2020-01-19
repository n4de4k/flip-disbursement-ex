<?php

spl_autoload_register(function ($class_name) {
    try {
        $name = str_replace('\\', '/', $class_name);
        include_once $name . '.php';
    } catch (Exception $e) {
        throw new Exception("Unable to load $name. Error: " . $e);
    }
});

use model\Transaction;
use repository\Transaction as TransactionRepo;
try {
    $trans = new Transaction;
    $trans->bank_code = "0232";
    $trans->amount = "12000000";


    $repo = new TransactionRepo;
    $repo->store($trans);
} catch (Exception $e) {
    var_dump($e);
}

?>
