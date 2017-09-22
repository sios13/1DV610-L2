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

    public function logout() {
        if ($this->isLoggedIn())
        {
            $this->messages[] = 'Bye bye!';
        }

        $this->sessionModel->set('isLoggedIn', false);
    }

    public function isLoggedIn() {
        return $this->sessionModel->has('isLoggedIn') && $this->sessionModel->get('isLoggedIn');
    }

    public function attemptLogin($username, $password) {
        if ($username == null)
        {
            return $this->messages[] = 'Username is missing';
        }

        if ($password == null)
        {
            return $this->messages[] = 'Password is missing';
        }

        $query = 'SELECT * FROM users WHERE name="' . $username . '" LIMIT 1';

        $users = $this->databaseModel->fetchAll($query);

        if (isset($users[0]) && $users[0]['password'] == $password)
        {
            if ($this->isLoggedIn() == false)
            {
                $this->messages[] = 'Welcome';
            }

            $this->sessionModel->set('isLoggedIn', true);
        }
        else
        {
            $this->messages[] = 'Wrong name or password';
        }
    }

}
