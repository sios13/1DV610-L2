<?php

namespace model;

class SessionModel {

    public function __construct() {}

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function has($key) : bool {
        return isset($_SESSION[$key]);
    }

    public function get($key) {
        return $_SESSION[$key];
    }

}
