<?php
namespace repository;

use libs\Dbo\Impl\Db;

class Transaction {
    private $db;
    function __construct() {
        $this->db = Db::getInstance();
    }

    public function store($data) {
        if (!$data->status) {
            $data->status = 'NEW';
        }
        
        return $this->db->save($data);
    }
}
