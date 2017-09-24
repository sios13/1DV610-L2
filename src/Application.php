<?php

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
        // create models
        // create base view
        // database model
        // session model/request model?
        // exceptions - gör model av exceptions. flera klasser i samma fil som extends \Exception
        // cookie model
        // test case -> controller
        // render i post

        // does user try to login
        // get user credantials
        // did the user login

        // create models
        $gatekeeperModel = new \model\GatekeeperModel(new \model\DatabaseModel());

        $view = new \view\LayoutView($gatekeeperModel);

        $requestPath = $this->getRequestPath();

        // if ($requestPath == '')
        // {
        //     $view = new \view\LayoutView($gatekeeperModel);

        //     $controller = new \controller\LoginController($gatekeeperModel, $view);
        // }
        // else if ($requestPath == '')
        // {
        //     $view = new \view\LayoutView(new RegisterView());

        //     $controller = new \controller\RegisterController($gatekeeperModel, $view);
        // }
        
        // $controller->indexAction();

        foreach ($this->routes as $route)
        {
            // Looking for a route with the requested url path
            if ($route['path'] == $requestPath)
            {
                // Initialize the controller
                $controller = new $route['controller']($gatekeeperModel, $view);

                // Run the controller-action
                $controller->{$route['action']}();
            }
        }
    }

    private function getRequestPath() {
        return '/' . join('/', array_keys($_GET));
    }

}
