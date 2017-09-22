<?php

namespace view;

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';
    
    private $gatekeeperModel;

    public function __construct($gatekeeperModel) {
        $this->gatekeeperModel = $gatekeeperModel;
    }

    public function userTriesToRegister() {
        return isset($_POST[self::$register]);
    }

    public function getUsername() {
        return $_POST[self::$name];
    }

    public function getPassword() {
        return $_POST[self::$password];
    }

    public function getPasswordRepeat() {
        return $_POST[self::$passwordRepeat];
    }

	public function response() {
        return '
            <h2>Register new user</h2>
            <form action="?register" method="post">
                <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                    <p id="' . self::$messageId . '">' . $this->getMessages() . '</p>
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

    private function getMessages() {
        return join('<br>', $this->gatekeeperModel->getMessages());
    }

    private function getRequestUserName() {
        return isset($_POST[self::$name]) ? $_POST[self::$name] : '';
    }
}
