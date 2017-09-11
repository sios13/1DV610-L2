<?php

namespace lab2;

class Database {

    private $services;

    function __construct() {}
        
    public function addServices($services) {
        $this->services = $services;
    }

}
