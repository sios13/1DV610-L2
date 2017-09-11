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
                unset($_SESSION['USER::isLoggedIn']);

                $_SESSION['message'] = 'Bye bye!';
            }
            else if (isset($_POST['LoginView::Login']) && !$this->userModel->isLoggedIn())
            {
                $username = $_POST['LoginView::UserName'];
                $password = $_POST['LoginView::Password'];

                $_SESSION['USER::username'] = $username;
    
                if ($username == '')
                {
                    $_SESSION['message'] = 'Username is missing';
                }
                else if ($password == '')
                {
                    $_SESSION['message'] = 'Password is missing';
                }
                else
                {
                    if ($username == $this->userModel->getUsername() && $password == $this->userModel->getPassword())
                    {
                        $_SESSION['USER::isLoggedIn'] = true;

                        $_SESSION['message'] = 'Welcome';
                    }
                    else
                    {
                        $_SESSION['message'] = 'Wrong name or password';
                    }
                }
            }

            return header("Location: " . $_SERVER['REQUEST_URI']);
        }

        $this->services['view']->setOutput($this->layoutView->render($loginView));

        unset($_SESSION['message']);
        unset($_SESSION['USER::username']);
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
                
                $_SESSION['USER::username'] = $username;

                if (strlen($username) < 3)
                {
                    $_SESSION['message'] = 'Username has too few characters, at least 3 characters.';
                }
                else if (strlen($password) < 6)
                {
                    $_SESSION['message'] .= 'Password has too few characters, at least 6 characters.';
                }
            }
            
            return header("Location: " . $_SERVER['REQUEST_URI']);
        }

        $this->services['view']->setOutput($this->layoutView->render($registerView));

        unset($_SESSION['message']);
        unset($_SESSION['USER::username']);
    }

}
