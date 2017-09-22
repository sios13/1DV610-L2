<?php

namespace model;

class RequestModel {

    public function __construct() {}

    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function has($key) {
        return isset($_REQUEST[$key]);
    }

    public function get($key) {
        if ($this->has($key))
        {
            return $_REQUEST[$key];
        }

        return null;
    }

    public function set($key, $value) {
        $_REQUEST[$key] = $value;
    }

}
