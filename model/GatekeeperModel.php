<?php

namespace model;

class GatekeeperModel {

    private $databaseModel;

    private $sessionModel;
    
    private $message;

    private $username;

    public function __construct($databaseModel, $sessionModel) {
        $this->message = '';

        $this->databaseModel = $databaseModel;

        $this->sessionModel = $sessionModel;

        $this->username = '';
    }

    public function getErrorMessage() : string {
        return $this->message;
    }

    public function getUsername() : string {
        return $this->username;
    }

    public function login() {
        $this->sessionModel->set('isLoggedIn', true);
    }

    public function logout() {
        $this->sessionModel->set('isLoggedIn', false);
    }

    public function isLoggedIn() {
        return $this->sessionModel->has('isLoggedIn') && $this->sessionModel->get('isLoggedIn');
    }

    public function isAllowedAccess($username, $password) {
        $this->username = "hehe";

        if ($username == null)
        {
            $this->message = 'Username is missing';

            return false;
        }

        if ($password == null)
        {
            $this->message = 'Password is missing';

            return false;
        }

        $query = 'SELECT * FROM users WHERE name="' . $username . '" LIMIT 1';

        $rows = $this->databaseModel->fetchAll($query);

        if (count($rows) == 1 && $rows[0]['password'] == $password)
        {
            return true;
        }

        $this->message = 'Wrong name or password';

        return false;

        // return count($rows) == 1 && $rows[0]['password'] == $password;
    }

}
