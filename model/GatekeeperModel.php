<?php

namespace model;

class GatekeeperModel {

    private $databaseModel;

    private $sessionModel;
    
    private $messages;

    public function __construct($databaseModel, $sessionModel) {
        $this->databaseModel = $databaseModel;

        $this->sessionModel = $sessionModel;

        $this->messages = array();
    }

    public function getMessages() : array {
        return $this->messages;
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
        if ($username == null)
        {
            $this->messages[] = 'Username is missing';

            return false;
        }

        if ($password == null)
        {
            $this->messages[] = 'Password is missing';

            return false;
        }

        $query = 'SELECT * FROM users WHERE name="' . $username . '" LIMIT 1';

        $rows = $this->databaseModel->fetchAll($query);

        if (count($rows) == 1 && $rows[0]['password'] == $password)
        {
            return true;
        }

        $this->messages[] = 'Wrong name or password';

        return false;

        // return count($rows) == 1 && $rows[0]['password'] == $password;
    }

}
