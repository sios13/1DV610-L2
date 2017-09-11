<?php

namespace lab2;

class Router {

    private $services;

    private $routes;

    function __construct() {
        $this->routes = array();
    }

    public function addServices($services) {
        $this->services = $services;
    }

    public function addRoute($path, $controller, $action) {
        $this->routes[] = [
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function route() {
        $request_path = $this->getRequestPath();

        foreach($this->routes as $route)
        {
            // Looking for a route with the requested url path
            if ($route['path'] == $request_path)
            {
                $controller = new $route['controller'];
                $controller->addServices($this->services);

                if (method_exists($controller, 'initialize'))
                {
                    $controller->initialize();
                }

                $controller->{$route['action']}();
            }
        }
    }

    private function getRequestPath() {
        return '/' . join('/', array_keys($_GET));
    }

}
