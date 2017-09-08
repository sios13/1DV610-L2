<?php

class Router {

    private $service;

    function __construct() {

    }

    public function addService(Service $service) {
        $this->service = $service;
    }

    public function route() {
        $request = $this->service->getService('request');
        
        if ($request->getPost('LoginView::Login') == 'login') {
            echo "HEJ";
        }
    }

}
