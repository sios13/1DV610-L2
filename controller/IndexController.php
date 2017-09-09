<?php

class IndexController extends lab2\Controller {

    private $v;
    private $dtv;
    private $lv;

    public function initialize() {
        $this->v = new LoginView();
        $this->dtv = new DateTimeView();
        $this->lv = new LayoutView();
    }

    public function indexAction() {
        echo "indexAction";

        session_start();

        if ( isset($_SESSION['user']) )
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $this->v->setMessage("Du har loggat in :)");
            }

            $this->lv->render(true, $v, $dtv);
        }
        else
        {
            $this->lv->render(false, $v, $dtv);
        }
    }

    public function registerAction() {
        echo "registerAction";

        $v = new LoginView();
        $dtv = new DateTimeView();
        $lv = new LayoutView();

        $lv->render(false, $v, $dtv);
    }

    public function notFoundAction() {
        echo "Not found";
    }

}
