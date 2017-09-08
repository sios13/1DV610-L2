<?php

namespace lab2;

use lab2\Router;
use lab2\Request;

class Service {

    private $services;
    
    function __construct() {
        $this->services = array();

        $this->services['router'] = new Router();
    }

    public function getService(string $serviceName) {
        return $this->services[$serviceName];
    }

}
