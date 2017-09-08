<?php

namespace lab2;

use lab2\Router;

class Service {

    private $services;
    
    function __construct() {
        $this->services = array();

        $this->services['router'] = new Router();
        $this->services['view'] = new View();
    }

    public function getService(string $serviceName) {
        return $this->services[$serviceName];
    }

}
