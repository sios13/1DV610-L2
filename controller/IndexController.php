<?php

class IndexController extends lab2\Controller {

    private $userModel;

    private $layoutView;

    public function initialize() {
        $this->userModel = new UserModel($this->services);

        $this->layoutView = new LayoutView($this->userModel);
    }

    public function indexAction() {
        $loginView = new LoginView($this->userModel);

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['LoginView::Logout']) && $this->userModel->isLoggedIn())
            {
                $this->userModel->logout();
            }
            else if (isset($_POST['LoginView::Login']) && $this->userModel->isLoggedIn() == false)
            {
                $postUsername = $_POST['LoginView::UserName'];
                $postPassword = $_POST['LoginView::Password'];

                $_SESSION['UsernameInput'] = $postUsername;

                if ($postUsername == '')
                {
                    $_SESSION['message'] .= 'Username is missing';
                }
                else if ($postPassword == '')
                {
                    $_SESSION['message'] .= 'Password is missing';
                }
                else
                {
                    $this->userModel->setUsername($postUsername);
                    $this->userModel->setPassword($postPassword);

                    if ($this->userModel->attemptLogin())
                    {
                        $_SESSION['message'] .= 'Welcome';
                    }
                    else
                    {
                        $_SESSION['message'] .= 'Wrong name or password';
                    }
                }
            }

            return header("Location: " . $_SERVER['REQUEST_URI']);
        }

        $this->services['view']->setOutput($this->layoutView->render($loginView));

        unset($_SESSION['message']);
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

                $_SESSION['UsernameInput'] = $username;

                if ($password !== $passwordRepeat)
                {
                    $_SESSION['message'] .= 'Passwords do not match.';
                }

                if ($canRegister) {
                    $userModel->register();
                }
            }

            return header("Location: " . $_SERVER['REQUEST_URI']);
        }

        $this->services['view']->setOutput($this->layoutView->render($registerView));

        unset($_SESSION['message']);
        unset($_SESSION['UsernameInput']);
    }

}
