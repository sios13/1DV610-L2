<?php

class UserModel extends lab2\Model {

    public function getUsername() {
        return 'Admin';
    }

    public function getPassword() {
        return 'Password';
    }

    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }

}
