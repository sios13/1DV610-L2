<?php

namespace controller;

class RegisterController {
    
    private $gatekeeperModel;

    private $view;

    public function __construct($gatekeeperModel, $view) {
        $this->gatekeeperModel = $gatekeeperModel;

        $this->view = $view;
    }

    public function indexAction() {
        $registerView = new \view\RegisterView($this->gatekeeperModel);

        if ($registerView->userTriesToRegister())
        {
            $username = $registerView->getUsername();
            $password = $registerView->getPassword();
            $passwordRepeat = $registerView->getPasswordRepeat();
            
            if ($this->gatekeeperModel->attemptRegister($username, $password, $passwordRepeat))
            {
                $_SESSION['successfull_registration_username'] = $username;

                header('Location: index.php');
            }
        }
        
        $this->view->render($registerView);
    }

}
