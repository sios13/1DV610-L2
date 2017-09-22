<?php

class LoginController {
    
    private $gatekeeperModel;

    private $view;

    public function __construct($gatekeeperModel, $view) {
        $this->gatekeeperModel = $gatekeeperModel;

        $this->view = $view;
    }

    public function indexAction() {
        $loginView = new \view\LoginView($this->gatekeeperModel);

        if ($loginView->userTriesToLogIn())
        {
            $username = $loginView->getUsername();
            $password = $loginView->getPassword();

            $this->gatekeeperModel->attemptLogin($username, $password);

            if ($loginView->getCookieKeep() !== null)
            {
                $loginView->setCookie();
            }
        }

        else if ($loginView->userTriesToLogOut())
        {
            $this->gatekeeperModel->logout();
        }

        $this->view->render($loginView);
    }

}
