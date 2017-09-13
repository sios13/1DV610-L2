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

    private function isAuthenticatedWithDb() {
        $query = 'SELECT * FROM users WHERE name="' . $this->username . '" LIMIT 1';

        $rows = $this->services['database']->query($query);

        if ($rows[0]['password'] == $this->password)
        {
            return true;
        }

        return false;
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
        if ($this->isAuthenticatedWithDb())
        {
            $_SESSION['User::IsLoggedIn'] = true;

            if (isset($_POST['LoginView::KeepMeLoggedIn']))
            {
                setcookie('LoginView::CookieName', $this->username, time() + 3600);
                setcookie('LoginView::CookiePassword', $this->password, time() + 3600);
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
