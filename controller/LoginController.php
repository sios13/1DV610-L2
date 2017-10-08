<?php

namespace controller;

class LoginController {

    private $gatekeeperModel;
    private $layoutView;

    public function __construct(\model\GatekeeperModel $gatekeeperModel, \view\LayoutView $layoutView) {
        $this->gatekeeperModel = $gatekeeperModel;
        $this->layoutView = $layoutView;
    }

    public function handle() {
        $loginView = new \view\LoginView($this->gatekeeperModel);

        $this->handleCookieLogin($loginView);

        if ($loginView->userTriesToLogin()) {
            $this->handleLogin($loginView);
        }
        if ($loginView->userTriesToLogout()) {
            $this->handleLogout($loginView);
        }

        $this->layoutView->setView($loginView);
    }

    private function handleLogin(\view\LoginView $loginView) {
        if ($this->gatekeeperModel->isLoggedIn()) {
            return;
        }

        $userCredentials = $loginView->getUserCredentials();

        if ($userCredentials === null) {
            return;
        }

        $username = $userCredentials->getUsername();
        $password = $userCredentials->getPassword();

        if ($this->gatekeeperModel->login($username, $password)) {
            if ($loginView->userWantsToBeRemembered()) {
                $loginView->setCookie($userCredentials);
                $this->gatekeeperModel->addCookie($userCredentials);
            }

            $loginView->enableWelcomeMessage();
        }
        else {
            $loginView->enableWrongCredentialsMessage();
        }
    }

    private function handleLogout(\view\LoginView $loginView) {
        if ($this->gatekeeperModel->isLoggedIn()) {
            $loginView->enableByeMessage();
        }

        $loginView->removeCookie();
        $this->gatekeeperModel->logout();
    }

    private function handleCookieLogin(\view\LoginView $loginView) {
        if ($this->gatekeeperModel->isLoggedIn()) {
            return;
        }

        $username = $loginView->getCookieUsername();
        $password = $loginView->getCookiePassword();

        if ($username === null || $password === null) {
            return;
        }

        if ($this->gatekeeperModel->login($username, $password)) {
            $loginView->enableWelcomeMessageCookie();
        } else {
            $loginView->enableWrongCredentialsMessageCookie();
        }

    }

}
