<?php

namespace controller;

class MasterController {

    private $gatekeeperModel;
    private $layoutView;

    public function __construct(\model\GatekeeperModel $gatekeeperModel, \view\LayoutView $layoutView) {
        $this->gatekeeperModel = $gatekeeperModel;
        $this->layoutView = $layoutView;
    }

    public function handleRequest() {
        // Routing
        if ($this->layoutView->userWantsToLogin()) {
            $loginController = new \controller\LoginController($this->gatekeeperModel, $this->layoutView);
            $loginController->handle();
        }
        else if ($this->layoutView->userWantsToRegister()) {
            $registerController = new \controller\RegisterController($this->gatekeeperModel, $this->layoutView);
            $registerController->handleRegister();
        }
    }

}
