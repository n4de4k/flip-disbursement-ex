<?php
namespace libs;

class Model {
    private $_data;
    const FILTERED_COLUMN = ['_table', '_data'];    

    function getVars() {
        $data = get_object_vars($this);

        foreach (self::FILTERED_COLUMN as $item) {
            unset($data[$item]);
        }

        $this->_data = $data;
    }

    public function getData() {
        $this->getVars();

        return $this->_data;
    }
}

?>