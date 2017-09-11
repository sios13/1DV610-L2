<?php


class LayoutView {

  private $userModel;

  public function __construct($userModel) {
    $this->userModel = $userModel;
  }

  public function render($view) {
    return '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn() . '
          
          <div class="container">
              ' . $view->response() . '
              
              <p>' . $this->renderDate() . '</p>
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn() {
    if ($this->userModel->isLoggedIn()) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function renderDate() {
    return date('l, \t\h\e jS \of F Y, \T\h\e \t\i\m\e \i\s h:i:s');
  }
}
