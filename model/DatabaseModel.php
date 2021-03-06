<?php

namespace model;

class DatabaseModel {

    private $dbh;

    public function __construct() {
        $dir = 'sqlite:../db.db';
        $this->dbh  = new \PDO($dir) or die('cannot open the database');
    }

    private function fetchAll($query) {
        return $this->dbh->query($query)->fetchAll();
    }

    public function addCookie($username, $tempPassword, $timeout) {
        $query = "UPDATE users SET cookie_password = :tempPassword, cookie_timer = :timeout WHERE name = :username";

        $statement = $this->dbh->prepare($query);
        $statement->bindValue(':tempPassword', $tempPassword);
        $statement->bindValue(':timeout', $timeout);
        $statement->bindValue(':username', $username);

        return $statement->execute();
    }

    public function addUser($username, $password) {
        $query = "INSERT INTO users (name, password) VALUES (:name, :password)";

        $statement = $this->dbh->prepare($query);
        $statement->bindValue(':name', $username);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));

        return $statement->execute();
    }

    private function getUser($username) {
        $query = 'SELECT * FROM users WHERE name="' . $username . '" LIMIT 1;';

        $users = $this->fetchAll($query);

        return isset($users[0]) ? $users[0] : null;
    }

    public function userExists($username) {
        return $this->getUser($username) !== null;
    }

    public function authenticateUser($username, $password) : bool {
        $user = $this->getUser($username);

        return $this->userExists($username)
            && (password_verify($password, $user['password']) || $password === $user['cookie_password']);
    }

    public function getAllUsers() {
        $users = $this->fetchAll('SELECT * FROM users;');
        $usernames = array();
        foreach ($users as $user) {
            $usernames[] = $user['name'];
        }
        return $usernames;
    }

}
