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

    public function isLoggedIn() {
        return $this->sessionModel->has('isLoggedIn') && $this->sessionModel->get('isLoggedIn');
    }

    public function logout() {
        if ($this->isLoggedIn())
        {
            $this->messages[] = 'Bye bye!';
        }

        $this->sessionModel->set('isLoggedIn', false);
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

    public function attemptRegister($username, $password, $passwordRepeat) {
        if ($this->infoIsCorrect($username, $password, $passwordRepeat))
        {
             // TODO register
        }
    }

    private function infoIsCorrect($username, $password, $passwordRepeat) {
        $infoIsCorrect = true;

        if ($username == null || strlen($username) < 3)
        {
            $this->messages[] = 'Username has too few characters, at least 3 characters.';

            $infoIsCorrect = false;
        }

        if ($password == null || strlen($password) < 6)
        {
            $this->messages[] = 'Password has too few characters, at least 6 characters.';
            
            $infoIsCorrect = false;
        }

        if ($password != $passwordRepeat)
        {
            $this->messages[] = 'Passwords do not match.';
            
            $infoIsCorrect = false;
        }

        return $infoIsCorrect;
    }

}
