<?php

class IndexController extends lab2\Controller {

    private $userModel;

    private $layoutView;

    public function initialize() {
        $this->userModel = new UserModel($this->services);

        $this->layoutView = new LayoutView($this->userModel);
    }

    private function addMessage($message) {
        if (isset($_SESSION['messages']) == false)
        {
            $_SESSION['messages'] = '';
        }

        $_SESSION['messages'] .= $message . '<br>';
    }

    public function indexAction() {
        $loginView = new LoginView($this->userModel);

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['LoginView::Logout']))
            {
                $this->userModel->logout();
            }
            else if (isset($_POST['LoginView::Login']))
            {
                $postUsername = $_POST['LoginView::UserName'];
                $postPassword = $_POST['LoginView::Password'];

                $_SESSION['UsernameInput'] = $postUsername;

                if ($postUsername == '')
                {
                    $this->addMessage('Username is missing');
                }
                else if ($postPassword == '')
                {
                    $this->addMessage('Password is missing');
                }
                else
                {
                    $this->userModel->setUsername($postUsername);
                    $this->userModel->setPassword($postPassword);

                    // Only login if not already logged in
                    if ($this->userModel->isLoggedIn() == false)
                    {
                        if ($this->userModel->attemptLogin())
                        {
                            $this->addMessage('Welcome');
                        }
                        else
                        {
                            $this->addMessage('Wrong name or password');
                        }
                    }

                }
            }

            return header("Location: " . $_SERVER['REQUEST_URI']);
        }

        $this->services['view']->setOutput($this->layoutView->render($loginView));

        unset($_SESSION['messages']);
        unset($_SESSION['UsernameInput']);
    }

    public function registerAction() {
        $registerView = new RegisterView();

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['RegisterView::Register']))
            {
                $username = $_POST['RegisterView::UserName'];
                $password = $_POST['RegisterView::Password'];
                $passwordRepeat = $_POST['RegisterView::PasswordRepeat'];

                $this->userModel->setUsername($username);
                $this->userModel->setPassword($password);

                $_SESSION['UsernameInput'] = $username;

                if ($password !== $passwordRepeat)
                {
                    $this->addMessage('Passwords do not match.');
                }
                else if ($this->userModel->register())
                {
                    $this->addMessage('Success!');
                }
            }

            return header("Location: " . $_SERVER['REQUEST_URI']);
        }

        $this->services['view']->setOutput($this->layoutView->render($registerView));

        unset($_SESSION['messages']);
        unset($_SESSION['UsernameInput']);
    }

}
