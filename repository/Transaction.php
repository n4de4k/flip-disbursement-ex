<?php
namespace repository;

use interfaces\TransactionRepoInterface;
use libs\Db;

class Transaction implements TransactionRepoInterface {
    private $db;
    function __construct() {
        $this->db = Db::getInstance();
    }

    public function store($data) {
        if (!$data->status) {
            $data->status = 'NEW';
        }
        
        $this->db->save($data);
    }
}
?>