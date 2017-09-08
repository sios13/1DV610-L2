<?php

class Request {

    function __construct() {

    }

    public function getPost($index) {
        if (isset($_POST[$index]) && !empty($_POST[$index])) {
            return $_POST[$index];
        }

        return null;
    }

}
