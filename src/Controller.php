<?php

namespace lab2;

class Controller {

    private $service;

    function __construct() {}

    public function addService(Service $service) {
        $this->service = $service;
    }

}
