<?php

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
            
            $this->gatekeeperModel->attemptRegister($username, $password, $passwordRepeat);
        }
        
        $this->view->render($registerView);
    }

}
