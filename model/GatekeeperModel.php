<?php

namespace model;

class GatekeeperModel {

    private static $isLoggedIn = 'GatekeeperModel::isLoggedIn';
    private static $browser = 'GatekeeperModel::Browser';

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

    public function isLoggedIn() : bool {
        return $this->sessionModel->has(self::$isLoggedIn) && $this->sessionModel->get(self::$isLoggedIn);
    }

    public function checkBrowser() {
        if ($this->sessionModel->has(self::$browser))
        {
            if ($this->sessionModel->get(self::$browser) !== $_SERVER['HTTP_USER_AGENT'])
            {
                $this->logout();
            }
        }
    }

    public function logout() {
        if ($this->isLoggedIn())
        {
            $this->messages[] = 'Bye bye!';
        }

        $this->sessionModel->set(self::$isLoggedIn, false);
    }

    public function addCookie($username, $tempPassword, $timeout) : bool {
        return $this->databaseModel->addCookie($username, $tempPassword, $timeout);
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

            $this->sessionModel->set(self::$isLoggedIn, true);
            $this->sessionModel->set(self::$browser, $_SERVER['HTTP_USER_AGENT']);
        }
        else
        {
            $this->messages[] = 'Wrong name or password';
        }
    }

    public function attemptCookieLogin($cookieUsername, $cookiePassword) {
        if ($this->isLoggedIn())
        {
            return;
        }

        if ($this->databaseModel->authenticateUserCookie($cookieUsername, $cookiePassword))
        {
            $this->messages[] = 'Welcome back with cookie';

            $this->sessionModel->set(self::$isLoggedIn, true);
            $this->sessionModel->set(self::$browser, $_SERVER['HTTP_USER_AGENT']);
        }
        else
        {
            $this->messages[] = 'Wrong information in cookies';
        }
    }

    public function attemptRegister($username, $password, $passwordRepeat) : bool {
        if ($this->infoIsCorrect($username, $password, $passwordRepeat) == false)
        {
            return false;
        }

        $this->messages[] = 'Registered new user.';

        return $this->databaseModel->addUser($username, $password);
    }

    private function infoIsCorrect($username, $password, $passwordRepeat) : bool {
        $infoIsCorrect = true;

        if (strlen($username) < 3)
        {
            $this->messages[] = 'Username has too few characters, at least 3 characters.';

            $infoIsCorrect = false;
        }

        if ($username !== strip_tags($username))
        {
            $this->messages[] = 'Username contains invalid characters.';

            $infoIsCorrect = false;
        }

        if (strlen($password) < 6)
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

            return false;
        }

        return $infoIsCorrect;
    }

}
