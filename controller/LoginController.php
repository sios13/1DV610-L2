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

        // $this->gatekeeperModel->checkBrowser();

        // If not logged in and there is a cookie
        if ($this->gatekeeperModel->isLoggedIn() == false && $loginView->getCookieName() !== null)
        {
            $this->gatekeeperModel->attemptCookieLogin($loginView->getCookieName(), $loginView->getCookiePassword());

            if ($this->gatekeeperModel->isLoggedIn())
            {
                $this->addTempPasswordAndTimeout($loginView);
            }

            else if ($this->gatekeeperModel->isLoggedIn() == false)
            {
                $loginView->removeCookie();

                $this->gatekeeperModel->logout();
            }
        }

        if ($loginView->userTriesToLogIn() && $this->gatekeeperModel->isLoggedIn() == false)
        {
            $username = $loginView->getUsername();
            $password = $loginView->getPassword();

            $this->gatekeeperModel->attemptLogin($username, $password);

            if ($loginView->getCookieKeep() !== null && $this->gatekeeperModel->isLoggedIn())
            {
                $this->addTempPasswordAndTimeout($loginView);
            }
        }

        else if ($loginView->userTriesToLogOut())
        {
            $loginView->removeCookie();

            $this->gatekeeperModel->logout();
        }

        $this->view->render($loginView);
    }

    private function addTempPasswordAndTimeout($loginView) {
        $tempPassword = md5(chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)));
        $timeout = time() + 3600;

        $loginView->setCookie($tempPassword, $timeout);

        $this->gatekeeperModel->addCookie($loginView->getUsername(), $tempPassword, $timeout);
    }

}
