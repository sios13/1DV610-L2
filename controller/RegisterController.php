<?php

class RegisterController {
    
    private $gatekeeperModel;

    private $view;

    public function __construct($gatekeeperModel, $view) {
        $this->gatekeeperModel = $gatekeeperModel;

        $this->view = $view;
    }

    public function indexAction() {
        $registerView = new \view\RegisterView($gatekeeperModel);

        if ($registerView->userTriesToRegister())
        {
            $username = $registerView->getUsername();
            $password = $registerView->getPassword();
            $passwordRepeat = $registerView->getPasswordRepeat();
            
            $this->gatekeeperModel->register($username, $password, $passwordRepeat);
        }
        
        $this->view->render($registerView);
    }

}
