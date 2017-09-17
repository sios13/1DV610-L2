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

    public function indexAction() {
        $loginView = new LoginView($this->userModel);

        // if posting
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
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

            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        $this->layoutView->render($loginView);

        unset($_SESSION['messages']);
        unset($_SESSION['UsernameInput']);
    }

    public function registerAction() {
        $registerView = new RegisterView($this->userModel);

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['RegisterView::Register']))
            {
                $username = $_POST['RegisterView::UserName'];
                $password = $_POST['RegisterView::Password'];
                $passwordRepeat = $_POST['RegisterView::PasswordRepeat'];

                $this->userModel->setUsername($username);
                $this->userModel->setPassword($password);

                $_SESSION['UsernameInput'] = strip_tags($username);

                if ($password !== $passwordRepeat)
                {
                    $this->addMessage('Passwords do not match.');
                }
                else if ($this->userModel->register())
                {
                    $this->addMessage('Success!');
                }
            }

            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        $this->layoutView->render($registerView);

        unset($_SESSION['messages']);
        unset($_SESSION['UsernameInput']);
    }

}
