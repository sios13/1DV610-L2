<?php

namespace model;

class RequestModel {

    public function get($key) {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
    }

    public function set($key, $value) {
        $_REQUEST[$key] = $value;
    }

}
