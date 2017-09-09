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
        $request_path = '/' . join('/', array_keys($_GET));

        foreach($this->routes as $route)
        {
            // Looking for a route with the requested url path
            if ($route['path'] == $request_path)
            {
                $controller = new $route['controller'];

                if (method_exists($controller, 'initialize'))
                {
                    $controller->initialize();
                }

                $controller->{$route['action']}();
            }
        }
    }

}
