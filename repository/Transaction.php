<?php
namespace repository;

use libs\Dbo\Impl\Db;
use model\Transaction as TransactionModel;
class Transaction {
    private $db;
    function __construct() {
        $this->db = Db::getInstance();
    }

    public function store(TransactionModel $data) {
        if (!$data->status) {
            $data->status = 'NEW';
        }
        
        $insertedId =  $this->db->save($data);
        $data->id = $insertedId;

        return $data;
    }

    public function get(TransactionModel $data) {
        if (!$data->id) {
            throw new \Exception('id can\'t be null');
        }

        $result = $this->db->findById($data);
        if (!$result) {
            throw new \Exception('Transaction Data not found');
        }

        $reflectionClass = new \ReflectionClass($data);
        foreach ($result as $key => $value) {
            $reflectionClass->getProperty($key)->setValue($data, $value);
        }
        return $data;
    }

    public function updateOne(TransactionModel $data) {
        $data = $this->db->update($data);

        return $data;
    }
}
