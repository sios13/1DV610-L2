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
            if (isset($_POST['LoginView::Logout']))
            {
                unset($_SESSION['user']);

                $loginView->setMessage('Bye bye!');
            }
            else if (isset($_POST['LoginView::Login']))
            {
                $username = $_POST['LoginView::UserName'];
                $password = $_POST['LoginView::Password'];
    
                if ($username == '')
                {
                    $loginView->setMessage('Username is missing');
                }
                else if ($password == '')
                {
                    $loginView->setMessage('Password is missing');
                }
                else
                {
                    if ($username == $this->userModel->getUsername() && $password == $this->userModel->getPassword())
                    {
                        $_SESSION['user'] = 'Admin';
    
                        $loginView->setMessage('Welcome');
                    }
                    else
                    {
                        $loginView->setMessage('Wrong name or password');
                    }
                }
            }
        }

        $this->services['view']->setOutput($this->layoutView->render($loginView));
    }

    public function registerAction() {
        $registerView = new RegisterView();

        $this->view->setOutput($this->layoutView->render(isset($_SESSION['user']), $registerView));
    }

}
