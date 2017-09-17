<?php

namespace lab2;

class Database {

    private $services;

    private $dbh;

    function __construct() {
        $dir = 'sqlite:db.db';
        $this->dbh  = new \PDO($dir) or die('cannot open the database');
    }
        
    public function addServices($services) {
        $this->services = $services;
    }

    public function fetchAll($query) {
        return $this->dbh->query($query)->fetchAll();
    }

    public function insert($query) {
        $statement = $this->dbh->prepare($query);

        $statement->bindValue(':name', 'hejhej');
        $statement->bindValue(':password', 'hejhej');

        return $statement->execute();
    }

}
