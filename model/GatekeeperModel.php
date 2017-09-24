<?php

namespace model;

class GatekeeperModel {

    private $databaseModel;

    private $sessionModel;
    
    private $messages;

    public function __construct($databaseModel) {
        $this->databaseModel = $databaseModel;

        $this->sessionModel = new \model\SessionModel();

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

        if ($this->databaseModel->authenticateUser($username, $password))
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

    public function attemptCookieLogin($cookieUsername, $cookiePassword) {
        if ($this->databaseModel->authenticateUser($cookieUsername, $cookiePassword))
        {
            if ($this->isLoggedIn() == false)
            {
                $this->messages[] = 'Welcome back with cookie';
            }

            $this->sessionModel->set('isLoggedIn', true);
        }
        else
        {
            $this->messages[] = 'Wrong information in cookies';
        }
    }

    public function attemptRegister($username, $password, $passwordRepeat) {
        if ($this->infoIsCorrect($username, $password, $passwordRepeat) == false)
        {
            return;
        }
    }

    private function infoIsCorrect($username, $password, $passwordRepeat) {
        $infoIsCorrect = true;

        if ($username == null || strlen($username) < 3)
        {
            $this->messages[] = 'Username has too few characters, at least 3 characters.';

            $infoIsCorrect = false;
        }

        if ($username !== strip_tags($username))
        {
            $this->messages[] = 'Username contains invalid characters.';

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

        if ($this->databaseModel->userExists($username, $password))
        {
            $this->messages[] = 'User exists, pick another username.';
        }

        return $infoIsCorrect;
    }

}
