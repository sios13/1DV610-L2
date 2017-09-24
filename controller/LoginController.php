<?php

namespace controller;

class LoginController {
    
    private $gatekeeperModel;

    private $view;

    public function __construct($gatekeeperModel, $view) {
        $this->gatekeeperModel = $gatekeeperModel;

        $this->view = $view;
    }

    public function indexAction() {
        $loginView = new \view\LoginView($this->gatekeeperModel);

        if ($loginView->getCookieName() !== null)
        {
            $this->gatekeeperModel->attemptCookieLogin($loginView->getCookieName(), $loginView->getCookiePassword());

            if ($this->gatekeeperModel->isLoggedIn() == false)
            {
                $loginView->removeCookie();

                $this->gatekeeperModel->logout();
            }
        }

        if ($loginView->userTriesToLogIn())
        {
            $username = $loginView->getUsername();
            $password = $loginView->getPassword();

            $this->gatekeeperModel->attemptLogin($username, $password);

            if ($loginView->getCookieKeep() !== null && $this->gatekeeperModel->isLoggedIn())
            {
                $loginView->setCookie();
            }
        }

        else if ($loginView->userTriesToLogOut())
        {
            $loginView->removeCookie();

            $this->gatekeeperModel->logout();
        }

        if (isset($_SESSION['successfull_registration_username']))
        {
            $loginView->setUsernameInput($_SESSION['successfull_registration_username']);

            unset($_SESSION['successfull_registration_username']);
        }

        $this->view->render($loginView);
    }

}
