<?php

class UserModel extends lab2\Model {

    public function getUsername() {
        $usernameFromPost = $_POST['LoginView::UserName'];

        $query = 'SELECT * FROM users WHERE name="' . $usernameFromPost . '" LIMIT 1';

        $rows = $this->services['database']->query($query);

        if (count($rows) == 1)
        {
            return $rows[0]['name'];
        }

        return '';
    }

    public function getPassword() {
        $usernameFromPost = $_POST['LoginView::UserName'];

        $query = 'SELECT * FROM users WHERE name="' . $usernameFromPost . '" LIMIT 1';

        $rows = $this->services['database']->query($query);

        if (count($rows) == 1)
        {
            return $rows[0]['password'];
        }

        return '';
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
            else
            {
                $_SESSION['message'] = 'Wrong information in cookies';
            }
        }
    }

}
