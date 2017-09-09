<?php

class IndexController extends lab2\Controller {

    private $layoutView;

    public function initialize() {
        session_start();

        $this->layoutView = new LayoutView();
    }

    public function indexAction() {
        $loginView = new LoginView();

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $loginView->setMessage("Du har loggat in :)");
        }

        $this->layoutView->render(isset($_SESSION['user']), $loginView);

    }

    public function registerAction() {
        $registerView = new RegisterView();

        $this->layoutView->render(isset($_SESSION['user']), $registerView);
    }

    public function notFoundAction() {
        echo "Not found";
    }

}
