<?php

class UserModel {

    private $username;

    private $password;

    private $messages;

    public function __construct() {
        $this->username = null;

        $this->password = null;

        $this->db = new lab2\Database();
    }

    private function isAuthenticatedWithDb() {
        $query = 'SELECT * FROM users WHERE name="' . $this->username . '" LIMIT 1';

        $rows = $this->db->fetchAll($query);

        return count($rows) == 1 && $rows[0]['password'] == $this->password;
    }

    private function addMessage($message) {
        if (isset($_SESSION['messages']) == false)
        {
            $_SESSION['messages'] = array();
        }

        $_SESSION['messages'][] = $message;
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

    public function getMessages() {
        if (isset($_SESSION['messages']) == false)
        {
            return '';
        }

        return implode('<br>', $_SESSION['messages']);
    }

    public function attemptCookieLogin() {
        if (isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword']))
        {
            $this->username = $_COOKIE['LoginView::CookieName'];
            $this->password = $_COOKIE['LoginView::CookiePassword'];

            if ($this->isAuthenticatedWithDb())
            {
                $_SESSION['User::IsLoggedIn'] = true;

                $this->addMessage('Welcome back with cookie');
            }
            else
            {
                $this->addMessage('Wrong information in cookies');

                $this->logout();
            }
        }
    }

    public function login() {
        if ($this->username == null)
        {
            return $this->addMessage('Username is missing');
        }

        if ($this->password == null)
        {
            return $this->addMessage('Password is missing');
        }

        if ($this->isAuthenticatedWithDb())
        {
            if ($this->isLoggedIn() == false)
            {
                $this->addMessage('Welcome');
            }

            $_SESSION['User::IsLoggedIn'] = true;

            if (isset($_POST['LoginView::KeepMeLoggedIn']))
            {
                setcookie('LoginView::CookieName', $this->username, time() + 3600);
                setcookie('LoginView::CookiePassword', $this->password, time() + 3600);
            }
        }
        else
        {
            $this->addMessage('Wrong name or password');
        }
    }

    public function logout() {
        if ($this->isLoggedIn())
        {
            unset($_SESSION['User::IsLoggedIn']);

            setcookie('LoginView::CookieName', '', time() - 3600);
            setcookie('LoginView::CookiePassword', '', time() - 3600);

            $this->addMessage('Bye bye!');
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['User::IsLoggedIn']) && $_SESSION['User::IsLoggedIn'] == true;
    }

    public function register() {
        if ($this->canRegister())
        {
            $query = 'INSERT INTO users (name, password) VALUES (:name, :password);';

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

            $canRegister = false;
        }

        if (strlen($this->password) < 6)
        {
            $this->addMessage('Password has too few characters, at least 6 characters.');
            
            $canRegister = false;
        }

        return $canRegister;
    }

}
