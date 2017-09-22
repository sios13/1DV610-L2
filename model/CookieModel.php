<?php

namespace model;

class CookieModel {

    public function __construct() {}

    public function set($key, $value) {
        setcookie($key, $value, time() + 3600);
    }

}
