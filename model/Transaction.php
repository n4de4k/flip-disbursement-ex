<?php

namespace model;

use libs\Model\Impl\Model;

class Transaction extends Model {
    public $_table = 'transactions';
    public $bank_code;
    public $account_number;
    public $amount;
    public $remark;
    public $status;
    public $receipt;
    public $time_served;
}
