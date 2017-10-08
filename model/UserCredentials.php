<?php

namespace model;

class UserCredentials {

    private $username;
    private $password;
    private $tempPassword;
    private $timeout;

    public function __construct($username, $password) {
        if ($username === null || $username === '') {
            throw new \Exception\UsernameMissingException();
        }

        if ($password === null || $password === '') {
            throw new \Exception\PasswordMissingException();
        }

        $this->username = $username;
        $this->password = $password;
        $this->tempPassword = md5(chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)));
        $this->timeout = time() + 3600;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getTempPassword() {
        return $this->tempPassword;
    }

    public function getTimeout() {
        return $this->timeout;
    }

}
