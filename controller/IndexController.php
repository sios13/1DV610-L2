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

    private function render($view) {
        $this->layoutView->render($view);
    }

    public function indexAction() {
        if ($this->requestIsPost())
        {
            // if pressed the logout button
            if (isset($_POST['LoginView::Logout']))
            {
                $this->userModel->logout();
            }

            // if pressed the login button
            else if (isset($_POST['LoginView::Login']))
            {
                $this->userModel->setUsername($_POST['LoginView::UserName']);
                $this->userModel->setPassword($_POST['LoginView::Password']);

                $this->userModel->login();

                $_SESSION['UsernameInput'] = $this->userModel->getUsername();
            }

            $this->redirect();
        }

        $this->render(new LoginView($this->userModel));

        $this->resetSession();
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
