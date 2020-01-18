<?php

spl_autoload_register(function ($class_name) {
    $name = str_replace('\\', '/', $class_name);
    include $name . '.php';
});

use model\Transaction;

$trans = new Transaction;
$trans->bank_code = "0232";
$trans->amount = "12000000";

$trans->save();

?>
