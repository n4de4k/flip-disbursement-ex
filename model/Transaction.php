<?php

namespace model;

use libs\Model\Impl\Model;

class Transaction extends Model {
    public $_table = 'transactions';
    public $id;
    public $bank_code;
    public $account_number;
    public $fee;
    public $amount;
    public $remark;
    public $status;
    public $receipt;
    public $time_served;
    public $beneficiary_name;
    public $flip_trans_id;
}
