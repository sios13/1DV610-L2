<?php

namespace lab2;

abstract class Controller {

    private $service;

    function __construct() {}

    public function addService(Service $service) {
        $this->service = $service;
    }

}
