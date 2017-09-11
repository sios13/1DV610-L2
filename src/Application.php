<?php

namespace lab2;

class Application {

    private $services;

    public function __construct() {
        session_start();

        $this->services = [];
    }

    public function createService($serviceName, $callable) {
        $this->services[$serviceName] = $callable();
    }

    public function getService($serviceName) {
        return $this->services[$serviceName];
    }

    public function handle() {
        $this->addDependenciesToServices();

        $router = $this->services['router'];

        $router->route();
    }

    private function addDependenciesToServices() {
        foreach($this->services as $service) {
            $service->addServices($this->services);
        }
    }

}
