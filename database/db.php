<?php

class Database
{
    private $connection;

    public function connect() {
        $ds = DIRECTORY_SEPARATOR;
        $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
        $file = "{$base_dir}database{$ds}constants.php";
        include_once($file);
        $this->connection = new Mysqli(HOST, USER_NAME, PASSWORD, DB_NAME);
        if($this->connection) {
            // echo "Connected";
            return $this->connection;
        }     
        return "Database Connection Failed";
    }
}


?>