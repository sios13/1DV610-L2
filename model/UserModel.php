<?php

class UserModel extends lab2\Model {

    public function getUsername() {
        return 'Admin';
    }

    public function getPassword() {
        return 'Password';
    }

    public function isLoggedIn() {
        $this->attemptCookieLogin();

        return isset($_SESSION['USER::isLoggedIn']);
    }

    private function attemptCookieLogin() {
        if (isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword']))
        {
            if ($this->getUsername() == $_COOKIE['LoginView::CookieName']
                && $this->getPassword() == $_COOKIE['LoginView::CookiePassword'])
            {
                if (!isset($_SESSION['USER::isLoggedIn']))
                {
                    $_SESSION['message'] = 'Welcome back with cookie';
                }

                $_SESSION['USER::isLoggedIn'] = true;
            }
        }
    }

}
