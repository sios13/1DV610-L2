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

            if ($this->gatekeeperModel->isAllowedAccess($username, $password))
            {
                $this->gatekeeperModel->login();

                $loginView->enableWelcomeMessage();
            }
        }
        else if ($loginView->userTriesToLogOut())
        {
            $this->gatekeeperModel->logout();
        }

        $this->view->render($loginView);
    }

    public function registerAction() {
        if ($this->requestIsPost())
        {
            // if pressed the register button
            if (isset($_POST['RegisterView::Register']))
            {
                $this->userModel->setUsername($_POST['RegisterView::UserName']);
                $this->userModel->setPassword($_POST['RegisterView::Password']);
                $this->userModel->setPasswordRepeat($_POST['RegisterView::PasswordRepeat']);

                $this->userModel->register();
                
                $_SESSION['UsernameInput'] = strip_tags($_POST['RegisterView::UserName']);
            }

            $this->redirect();
        }

        $this->render(new RegisterView($this->userModel));
        
        $this->resetSession();
    }

}
