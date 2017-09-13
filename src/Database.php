<?php

namespace lab2;

class Database {

    private $services;

    private $dbh;

    function __construct() {
        $dir = 'sqlite:db.db';
        $this->dbh  = new \PDO($dir) or die("cannot open the database");

        // $query =  'SELECT * FROM users';
        // foreach ($dbh->query($query) as $row)
        // {
        //     echo $row[0] . $row[1];
        // }
    }
        
    public function addServices($services) {
        $this->services = $services;
    }

    public function query($query) {
        return $this->dbh->query($query)->fetchAll();
    }

}
