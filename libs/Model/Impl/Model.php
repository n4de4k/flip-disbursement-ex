<?php
namespace libs\Model\Impl;

use libs\Model\iModel;

class Model implements iModel{
    private $_data;
    const FILTERED_COLUMN = ['_table', '_data'];

    protected $created_at;
    protected $updated_at;

    function __construct() {
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }

    function getVars($ignoreNull) {
        $data = get_object_vars($this);

        foreach (self::FILTERED_COLUMN as $item) {
            unset($data[$item]);
        }

        if ($ignoreNull) {
            foreach ($data as $key => $value) {
                if (!$value) {
                    unset($data[$key]);
                }
            }
        }

        $this->_data = $data;
    }

    public function getData($igNoreNull = false) {
        $this->getVars($igNoreNull);

        return $this->_data;
    }
}

?>