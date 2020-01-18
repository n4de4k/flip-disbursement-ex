<?php

namespace libs;

class Db {
    public static $conn = null;

    public static function getInstance() {
        if (!self::$conn) {
            $conf = parse_ini_file('conf.ini');
            
            self::$conn = mysqli_connect($conf["DB_HOST"], $conf["DB_USERNAME"], $conf["DB_PASSWORD"], $conf["DB_NAME"]);

            if (self::$conn->connect_error) {
                throw new Exception('Connection to Mysql is failed');
            }
            
        }

        return self::$conn;
    }
}

?>