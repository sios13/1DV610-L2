<?php

class IndexController extends lab2\Controller {

    private $layoutView;

    public function initialize() {
        session_start();

        $this->layoutView = new LayoutView();
    }

    public function indexAction() {
        echo "indexAction";

        $loginView = new LoginView();

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $loginView->setMessage("Du har loggat in :)");
        }
        else
        {
            $loginView->setMessage("Hej :)");
        }

        $this->layoutView->render(isset($_SESSION['user']), $loginView);

    }

    public function registerAction() {
        echo "registerAction";

        $registerView = new RegisterView();

        $this->layoutView->render(isset($_SESSION['user']), $registerView);
    }

    public function notFoundAction() {
        echo "Not found";
    }

}
