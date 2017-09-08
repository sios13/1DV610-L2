<?php

require_once('src/Router.php');
require_once('src/Request.php');

class Service {

    private $services;
    
    function __construct() {
        $this->services = array();

        $this->services['router'] = new Router();
        $this->services['request'] = new Request();
    }

    public function getService(string $serviceName) {
        return $this->services[$serviceName];
    }

}
