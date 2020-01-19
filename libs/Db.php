<?php

namespace libs;

use libs\Model;

class Db {
    public static $instance = null;
    public $conn;

    public static function getInstance() {
        if (!self::$instance) {
            $db = new Db;
            $conf = parse_ini_file('conf.ini');
            
            $db->conn = mysqli_connect($conf["DB_HOST"], $conf["DB_USERNAME"], $conf["DB_PASSWORD"], $conf["DB_NAME"]);

            if ($db->conn->connect_error) {
                throw new Exception('Connection to Mysql is failed');
            }
            self::$instance = $db;
        }

        return self::$instance;
    }

    public function query($query) {
        $db = Db::getInstance();
        $res = mysqli_query($db->conn, $query);

        return $res;
    }

    public function save(Model $model) {
        $columnString = '';
        $valueString = '';

        foreach ($model->getData() as $column => $value) {
            if (!in_array($column, Model::FILTERED_COLUMN)) {
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

        $query = 'INSERT INTO ' .$model->_table .' (' . $columnString . ') VALUES (' . $valueString . ');';
        $res = $this->query($query);

        return $res;
    }
}

?>