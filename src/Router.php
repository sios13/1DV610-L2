<?php

namespace lab2;

class Router {

    private $service;

    private $routes;

    function __construct() {
        $this->routes = array();
    }

    public function addService(Service $service) {
        $this->service = $service;
    }

    public function addRoute($path, $controller, $action) {
        $this->routes[] = [
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function route() {
        $url_path = '/' . join('/', array_keys($_GET));

        foreach($this->routes as $route) {
            if ($route['path'] == $url_path) {
                $controller = new $route['controller'];
                $controller->{$route['action']}();
            }
        }
    }

}
