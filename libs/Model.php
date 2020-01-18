<?php
namespace libs;

class Model {
    protected $data;
    const FILTERED_COLUMN = ['table', 'data'];
    private function query($query) {
        $conn = Db::getInstance();
        $res = mysqli_query($conn, $query);

        return $res;
    }

    public function save() {
        $this->data = get_object_vars($this);
        $columnString = '';
        $valueString = '';

        foreach ($this->data as $column => $value) {
            if (!in_array($column, self::FILTERED_COLUMN)) {
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
        $res = $this->query($query);

        return $res;
    }
}

?>