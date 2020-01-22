<?php

spl_autoload_register(function ($class_name) {
    try {
        $name = str_replace('\\', '/', $class_name);
        include_once __DIR__ . '/' .$name . '.php';
    } catch (Exception $e) {
        throw new Exception("Unable to load $class_name. Error: " . $e);
    }
});

use libs\Dbo\Impl\Db;

$db = Db::getInstance();

$db->query("DROP DATABASE flip;");
$db->query("CREATE DATABASE flip;");
$db->query("use flip;");

$db->query("CREATE TABLE transactions (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        bank_code VARCHAR(100) ,
        account_number VARCHAR(100) ,
        fee INT(10) ,
        amount INT(10) ,
        remark VARCHAR(100) ,
        status VARCHAR(100) ,
        receipt TEXT ,
        time_served TIMESTAMP ,
        beneficiary_name VARCHAR(100) ,
        flip_trans_id BIGINT(20),
        created_at TIMESTAMP ,
        updated_at TIMESTAMP 
    )");