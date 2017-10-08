<?php

namespace model;

class CookieModel {

    public function get($key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    public function set($key, $value, $timeout) {
		setcookie($key, $value, $timeout);
    }

}
