<?php

class Router {

    private $service;

    function __construct() {

    }

    public function addService(Service $service) {
        $this->service = $service;
    }

    public function route() {
        
    }

}
