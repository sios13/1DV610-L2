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

        $rows = $this->services['database']->fetchAll($query);

        if (count($rows) == 1 && $rows[0]['password'] == $this->password)
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
                $_SESSION['message'] .= 'Welcome back with cookie';
            }
            else
            {
                $_SESSION['message'] .= 'Wrong information in cookies';

                $this->logout();
            }
        }
    }

    public function attemptLogin() {
        if ($this->isAuthenticatedWithDb())
        {
            $_SESSION['User::IsLoggedIn'] = $this->username;

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
        if ($this->isLoggedIn())
        {
            unset($_SESSION['User::IsLoggedIn']);

            setcookie('LoginView::CookieName', '', time() - 3600);
            setcookie('LoginView::CookiePassword', '', time() - 3600);

            $_SESSION['message'] .= 'Bye bye!';
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['User::IsLoggedIn']);
    }

    public function register() {
        if ($this->canRegister())
        {
            $query = 'INSERT INTO users (name, password) VALUES ("' . $this->username . '", "' . $this->password . '");';

            if ($this->services['database']->insert($query))
            {
                $this->addMessage('Success!');
            }
            else
            {
                $this->addMessage($query);
            }
        }
    }

    private function canRegister() {
        $canRegister = true;

        if (strlen($this->username) < 3)
        {
            $this->addMessage('Username has too few characters, at least 3 characters.');

            $canRegister = false;
        }

        if ($this->username != strip_tags($this->username))
        {
            $this->addMessage('Username contains invalid characters.');

            $_SESSION['UsernameInput'] = strip_tags($username);

            $canRegister = false;
        }

        if (strlen($this->password) < 6)
        {
            $this->addMessage('Password has too few characters, at least 6 characters.');
            
            $canRegister = false;
        }

        return $canRegister;
    }

    private function addMessage($message) {
        if (isset($_SESSION['messages']) == false)
        {
            $_SESSION['messages'] = '';
        }

        $_SESSION['messages'] .= $message . '<br>';
    }

}
