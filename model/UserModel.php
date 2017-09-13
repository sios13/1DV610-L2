<?php

class UserModel extends lab2\Model {

    private $username;

    private $password;

    public function __construct($services) {
        parent::__construct($services);

        if ($this->isLoggedIn() == false)
        {
            $this->attemptCookieLogin();
        }
    }

    private function isAuthenticatedWithDb($username, $password) {
        $query = 'SELECT * FROM users WHERE name="' . $username . '" AND password="' . $password . '" LIMIT 1';

        $rows = $this->services['database']->query($query);

        return count($rows) == 1;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function attemptCookieLogin() {
        if (isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword']))
        {
            $this->username = $_COOKIE['LoginView::CookieName'];
            $this->password = $_COOKIE['LoginView::CookiePassword'];

            if ($this->attemptLogin()) {
                $_SESSION['message'] = "Welcome back from cookie";
            }
        }
    }

    public function attemptLogin() {
        if ($this->isAuthenticatedWithDb($this->username, $this->password))
        {
            $_SESSION['User::IsLoggedIn'] = true;

            if (isset($_POST['LoginView::KeepMeLoggedIn']))
            {
                setcookie('LoginView::CookieName', $this->getUsername(), time() + 3600);
                setcookie('LoginView::CookiePassword', $this->getPassword(), time() + 3600);
            }

            return true;
        }

        return false;
    }

    public function logout() {
        unset($_SESSION['User::IsLoggedIn']);

        setcookie('LoginView::CookieName', '', time() - 3600);
        setcookie('LoginView::CookiePassword', '', time() - 3600);

        $_SESSION['message'] = 'Bye bye!';
    }

    public function isLoggedIn() {
        return isset($_SESSION['User::IsLoggedIn']);
    }

}
