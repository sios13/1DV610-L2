<?php

namespace controller;

class RegisterController {
    
    private $gatekeeperModel;

    private $view;

    public function __construct(\model\GatekeeperModel $gatekeeperModel, \view\LayoutView $view) {
        $this->gatekeeperModel = $gatekeeperModel;

        $this->view = $view;
    }

    public function indexAction() {
        $registerView = new \view\RegisterView($this->gatekeeperModel);

        // try {

        // } catch () {

        // }
        if ($registerView->userTriesToRegister())
        {
            $username = $registerView->getUsername();
            $password = $registerView->getPassword();
            $passwordRepeat = $registerView->getPasswordRepeat();
            
            if ($this->gatekeeperModel->attemptRegister($username, $password, $passwordRepeat))
            {
                $loginView = new \view\LoginView($this->gatekeeperModel);
                $loginView->setInputUsername($registerView->getUsername());
                return $this->view->render($loginView);
            }
        }
        
        $this->view->render($registerView);
    }

}
