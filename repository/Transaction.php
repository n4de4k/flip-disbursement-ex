<?php
namespace repository;

use libs\Dbo\Impl\Db;

class Transaction implements iTransaction {
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
