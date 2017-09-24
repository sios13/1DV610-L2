<?php

namespace model;

class DatabaseModel {

    private $dbh;

    function __construct() {
        $dir = 'sqlite:db.db';
        $this->dbh  = new \PDO($dir) or die('cannot open the database');
    }

    private function fetchAll($query) {
        return $this->dbh->query($query)->fetchAll();
    }
    
    public function addUser($username, $password) {
        $query = "INSERT INTO users VALUES (:name, :password)";

        $statement = $this->dbh->prepare($query);
        $statement->bindValue(':name', $username);
        $statement->bindValue(':password', $password);

        return $statement->execute();
    }

    public function userExists($username) {
        $query = 'SELECT * FROM users WHERE name="' . $username . '" LIMIT 1;';

        $users = $this->fetchAll($query);

        return isset($users[0]);
    }

    public function authenticateUser($username, $password) {
        $query = 'SELECT * FROM users WHERE name="' . $username . '" LIMIT 1;';

        $users = $this->fetchAll($query);

        return isset($users[0]) && $users[0]['password'] == $password;
    }

}
