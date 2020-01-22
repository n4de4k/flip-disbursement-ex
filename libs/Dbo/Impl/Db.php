<?php

namespace libs\Dbo\Impl;

use libs\Dbo\iDbo;

class Db implements iDbo {
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

        if (!$res) {
            throw new \Exception('Failed to run query: ' . $query . '. Error: ' . mysqli_error($db->conn));
        }
        return $res;
    }

    private function isString($value) {
        $valueType = gettype($value);
        return $valueType !== "boolean" &&
            $valueType !== 'integer' &&
            $valueType !== 'double' &&
            $valueType !== 'NULL';
    }

    public function save($model) {
        $columnString = '';
        $valueString = '';

        foreach ($model->getData() as $column => $value) {
            $columnString .= $column . ',';

            $isString = $this->isString($value);
            if ($isString) {
                $valueString .= '\'';
            }
            $valueString .= (empty($value) ? 'NULL' : $value);
            if ($isString) {
                $valueString .= '\'';
            }
            $valueString .= ',';
        }

        if (strlen($columnString) > 0) {
            $columnString = substr($columnString, 0, -1);
            $valueString = substr($valueString, 0, -1);
        }

        $query = 'INSERT INTO ' .$model->_table .' (' . $columnString . ') VALUES (' . $valueString . ');';
        $this->query($query);

        return $this->conn->insert_id;
    }

    public function update($model) {
        if (!$model->id) {
            throw new \Exception('To use this function, id  can\'t be null');
        }
        $model->updated_at = date('Y-m-d H:i:s');
        $query = 'UPDATE ' . $model->_table . ' SET';

        $i = 0;
        $data = $model->getData();
        $dataLength = count($data);

        foreach ($data as $column => $value) {
            if ($column !== 'id') {
                $query .= ' ' . $column . ' = ';
                $isString = $this->isString($value);
                if ($isString) {
                    $query .= '\'';
                }
                $query .= (empty($value) ? 'NULL' : $value);
                if ($isString) {
                    $query .= '\'';
                }

                if ($i < $dataLength - 2) {
                    $query .= ', ';
                }
                $i += 1;
            }
        }

        $query .= ' WHERE id = ' . $model->id . ';';

        $this->query($query);

        return $model;
    }

    public function findById($model) {
        $query = "SELECT * FROM " . $model->_table . " WHERE id = " . $model->id;

        $result = $this->query($query);

        if ($result->num_rows == 0) {
            return null;
        } else {
            $data = $result->fetch_assoc();

            return $data;
        }
    }
}