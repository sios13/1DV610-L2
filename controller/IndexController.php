<?php

class IndexController {

    private $userModel;

    private $layoutView;

    public function initialize() {
        $this->userModel = new UserModel();

        if ($this->userModel->isLoggedIn() == false)
        {
            $this->userModel->attemptCookieLogin();
        }

        $this->layoutView = new LayoutView($this->userModel);
    }

    private function requestIsPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    private function redirect() {
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }

    private function resetSession() {
        unset($_SESSION['messages']);
        unset($_SESSION['UsernameInput']);
    }

    public function indexAction() {
        if ($this->requestIsPost())
        {
            // if pressed the login button
            if (isset($_POST['LoginView::Logout']))
            {
                $this->userModel->logout();
            }

            // if pressed the logout button
            else if (isset($_POST['LoginView::Login']))
            {
                $this->userModel->setUsername($_POST['LoginView::UserName']);
                $this->userModel->setPassword($_POST['LoginView::Password']);

                $this->userModel->login();

                $_SESSION['UsernameInput'] = $this->userModel->getUsername();
            }

            $this->redirect();
        }

        $loginView = new LoginView($this->userModel);

        $this->layoutView->render($loginView);

        $this->resetSession();
    }

    public function registerAction() {
        if ($this->requestIsPost())
        {
            // if pressed the register button
            if (isset($_POST['RegisterView::Register']))
            {
                $username = $_POST['RegisterView::UserName'];
                $password = $_POST['RegisterView::Password'];
                $passwordRepeat = $_POST['RegisterView::PasswordRepeat'];

                $this->userModel->setUsername($username);
                $this->userModel->setPassword($password);
                $this->userModel->setPasswordRepeat($passwordRepeat);

                $_SESSION['UsernameInput'] = strip_tags($username);

                if ($this->userModel->register())
                {
                    $this->addMessage('Success!');
                }
            }

            $this->redirect();
        }

        $registerView = new RegisterView($this->userModel);

        $this->layoutView->render($registerView);
        
        $this->resetSession();
    }

}
