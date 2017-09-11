<?php

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';

	public function response() {
        return '
            <h2>Register new user</h2>
            <form action="?register" method="post">
                <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                    <p id="' . self::$messageId . '">' . $this->getMessage() . '</p>
                    <label for="' . self::$name . '">Username :</label>
                    <input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="' . $this->getRequestUserName() . '" />
                    <br/>
                    <label for="' . self::$password . '">Password  :</label>
                    <input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value="" />
                    <br/>
                    <label for="' . self::$passwordRepeat . '">Repeat password  :</label>
                    <input type="password" size="20" name="' . self::$passwordRepeat . '" id="' . self::$passwordRepeat . '" value="" />
                    <br/>
                    <input id="submit" type="submit" name="' . self::$register . '"  value="Register" />
                    <br/>
                </fieldset>
            </form>
        ';
    }
    
    private function getMessage() {
        if (isset($_SESSION['message'])) {
            return $_SESSION['message'];
        }

        return '';
    }

    private function getRequestUserName() {
        if (isset($_SESSION['USER::username'])) {
            return $_SESSION['USER::username'];
        }

        return '';
    }
}
