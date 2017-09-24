<?php

namespace controller;

class MasterController {
    
    public function indexAction() {
        session_start();

        $gatekeeperModel = new \model\GatekeeperModel(new \model\DatabaseModel());
        
        $view = new \view\LayoutView($gatekeeperModel);

        $requestPath = $this->getRequestPath();

        if ($requestPath == '/')
        {
            $controller = new \controller\LoginController($gatekeeperModel, $view);

            $controller->indexAction();
        }
        else if ($requestPath == '/register')
        {
            $controller = new \controller\RegisterController($gatekeeperModel, $view);

            $controller->indexAction();
        }
    }

    private function getRequestPath() {
        return '/' . join('/', array_keys($_GET));
    }

}
