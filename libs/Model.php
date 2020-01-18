<?php
namespace libs;

class Model {
    protected $data;

    public function save() {
        $this->data = get_object_vars($this);
        $columnString = '';
        $valueString = '';

        foreach ($this->data as $column => $value) {
            if ($column !== 'table') {
                $columnString .= $column . ',';

                $valueType = gettype($value);
                $isString = $valueType !== "boolean" && 
                            $valueType !== 'integer' &&
                            $valueType !== 'double' &&
                            $valueType !== 'NULL';
                if ($isString) {
                    $valueString .= '\'';
                }
                $valueString .= (empty($value) ? 'NULL' : $value);
                if ($isString) {
                    $valueString .= '\'';
                }
                $valueString .= ',';
            }
        }

        if (strlen($columnString) > 0) {
            $columnString = substr($columnString, 0, -1);
            $valueString = substr($valueString, 0, -1);
        }

        $query = 'INSERT INTO ' .$this->table .' (' . $columnString . ') VALUES (' . $valueString . ');';
        echo $query;
    }
}

?>