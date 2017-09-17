<?php

namespace lab2;

class Application {

    private $routes;

    public function __construct() {
        session_start();

        $this->routes = [];
    }

    public function addRoute($path, $controller, $action) {
        $this->routes[] = [
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function handleRequest() {
        $request_path = $this->getRequestPath();

        foreach ($this->routes as $route)
        {
            // Looking for a route with the requested url path
            if ($route['path'] == $request_path)
            {
                $controller = new $route['controller'];

                if (method_exists($controller, 'initialize'))
                {
                    $controller->initialize();
                }

                // Run the controller-action
                $controller->{$route['action']}();
            }
        }
    }

    private function getRequestPath() {
        return '/' . join('/', array_keys($_GET));
    }

}
