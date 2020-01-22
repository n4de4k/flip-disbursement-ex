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
}
