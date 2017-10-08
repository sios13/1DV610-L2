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

        if ($registerView->userTriesToRegister() && $registerView->userInfoIsValid()) {
            $username = $registerView->getUsername();
            $password = $registerView->getPassword();
            $passwordRepeat = $registerView->getPasswordRepeat();

            try {
                $this->gatekeeperModel->register($username, $password, $passwordRepeat);

                $loginView = new \view\LoginView($this->gatekeeperModel);
                $loginView->enableRegisteredMessage();
                $loginView->setInputUsername($registerView->getUsername());
                return $this->layoutView->setView($loginView);
            }
            catch (\Exception\UserExistsException $exception) {
                $registerView->enableUserExistsMessage();
            }
        }

        $this->layoutView->setView($registerView);
    }

}
