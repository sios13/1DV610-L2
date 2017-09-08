<?php

class IndexController extends lab2\Controller {

    function __construct() {

    }

    public function indexAction() {
        echo "indexAction";

        $v = new LoginView();
        $dtv = new DateTimeView();
        $lv = new LayoutView();

        $lv->render(false, $v, $dtv);
    }

    public function registerAction() {
        echo "registerAction";

        $v = new LoginView();
        $dtv = new DateTimeView();
        $lv = new LayoutView();

        $lv->render(false, $v, $dtv);
    }

}
