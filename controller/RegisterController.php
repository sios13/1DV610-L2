<?php

namespace controller;

class RegisterController {
    
    private $gatekeeperModel;
    private $view;

    public function __construct(\model\GatekeeperModel $gatekeeperModel, \view\LayoutView $layoutView) {
        $this->gatekeeperModel = $gatekeeperModel;
        $this->layoutView = $layoutView;
    }

    public function handleRegister() {
        $registerView = new \view\RegisterView($this->gatekeeperModel);

        if ($registerView->userTriesToRegister() && $registerView->userInfoIsValid())
        {
            $username = $registerView->getUsername();
            $password = $registerView->getPassword();
            $passwordRepeat = $registerView->getPasswordRepeat();
            
            if ($this->gatekeeperModel->register($username, $password, $passwordRepeat))
            {
                $loginView = new \view\LoginView($this->gatekeeperModel);
                $loginView->setInputUsername($registerView->getUsername());
                return $this->layoutView->render($loginView);
            }
        }

        $this->layoutView->setView($registerView);
    }

}
