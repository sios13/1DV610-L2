<?php

namespace model;

class GatekeeperModel {

    private static $isLoggedIn = 'GatekeeperModel::isLoggedIn';
    private static $browser = 'GatekeeperModel::Browser';

    private $databaseModel;
    private $sessionModel;

    public function __construct($databaseModel) {
        $this->databaseModel = $databaseModel;
        $this->sessionModel = new \model\SessionModel();
    }

    public function addCookie($userCredentials) : bool {
        $username = $userCredentials->getUsername();
        $tempPassword = $userCredentials->getTempPassword();
        $timeout = $userCredentials->getTimeout();

        return $this->databaseModel->addCookie($username, $tempPassword, $timeout);
    }

    public function isLoggedIn() : bool {
        return $this->sessionModel->get(self::$isLoggedIn)
            && $this->sessionModel->get(self::$browser) === $_SERVER['HTTP_USER_AGENT'];
    }

    public function login($username, $password) : bool {
        if ($this->isLoggedIn()) {
            return false;
        }

        if ($username === null || $password === null) {
            return false;
        }

        if ($this->databaseModel->authenticateUser($username, $password)) {
            $this->sessionModel->set(self::$isLoggedIn, true);
            $this->sessionModel->set(self::$browser, $_SERVER['HTTP_USER_AGENT']);

            return true;
        }

        return false;
    }

    public function logout() {
        $this->sessionModel->set(self::$isLoggedIn, false);
    }

    public function register($username, $password, $passwordRepeat) : bool {
        if ($this->databaseModel->userExists($username)) {
            throw new \Exception\UserExistsException();
        }

        return $this->databaseModel->addUser($username, $password);
    }

    public function getListOfUsernames() {
        return $this->databaseModel->getAllUsers();
    }

}
