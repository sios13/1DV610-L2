<?php

namespace view;

class LayoutView {

    private $gatekeeperModel;

    public function __construct($gatekeeperModel) {
        $this->gatekeeperModel = $gatekeeperModel;
    }

    public function render($view) {
        echo '<!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Login Example</title>
                </head>
                <body>
                    <h1>Assignment 2</h1>
                    ' . $this->renderRegisterOrBack() . '
                    ' . $this->renderLink() . '
          
                    <div class="container">
                        ' . $view->response() . '

                        <p>' . $this->getDate() . '</p>
                    </div>
                </body>
            </html>
        ';
    }

    private function renderRegisterOrBack() {
        if (isset($_GET['register']))
        {
            return '<a href="?">Back to login</a>';
        }

        return '<a href="?register">Register a new user</a>';
    }
  
    private function renderLink() {
        if ($this->gatekeeperModel->isLoggedIn())
        {
            return '<h2>Logged in</h2>';
        }
    
        return '<h2>Not logged in</h2>';
    }

    private function getDate() {
        return date('l, \t\h\e jS \of F Y, \T\h\e \t\i\m\e \i\s h:i:s');
    }

}
