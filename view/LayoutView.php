<?php

namespace view;

class LayoutView {

    private $view;
    private $gatekeeperModel;

    public function __construct($gatekeeperModel) {
        $this->gatekeeperModel = $gatekeeperModel;
    }

    public function setView($view) {
        $this->view = $view;
    }

    public function render($output) {
        echo $output;
    }

    public function generateOutput() {
        return '<!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Login Example</title>
                </head>
                <body>
                    <h1>Assignment 2</h1>
                    ' . $this->showLink() . '
                    ' . $this->showHeader() . '
          
                    <div class="container">
                        ' . $this->view->response() . '

                        <p>' . $this->showDate() . '</p>
                    </div>
                </body>
            </html>
        ';
    }

    private function showLink() {
        if (isset($_GET['register']) && !isset($_POST['RegisterView::Register']))
        {
            return '<a href="?">Back to login</a>';
        }

        return '<a href="?register">Register a new user</a>';
    }
  
    private function showHeader() {
        if ($this->gatekeeperModel->isLoggedIn())
        {
            return '<h2>Logged in</h2>';
        }
    
        return '<h2>Not logged in</h2>';
    }

    private function showDate() {
        return date('l, \t\h\e jS \of F Y, \T\h\e \t\i\m\e \i\s h:i:s');
    }

    public function userWantsToLogin() {
        return $this->getRequestedPath() === '/';
    }

    public function userWantsToRegister() {
        return $this->getRequestedPath() === '/register';
    }

    private function getRequestedPath() {
        return '/' . join('/', array_keys($_GET));
    }

}
