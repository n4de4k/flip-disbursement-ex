<?php

namespace model;

use libs\Model;

class Transaction extends Model {
    protected $table = 'transactions';
    public $bank_code;
    public $account_number;
    public $amount;
    public $remark;
    public $status;
    public $receipt;
    public $time_served;
}

?>