<?php

namespace lab2;

abstract class Controller {

    protected $services;

    function __construct() {}

    public function addServices($services) {
        $this->services = $services;
    }

}
