<?php

namespace view;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	private $gatekeeperModel;

	private $welcomeMessage;

	public function __construct($gatekeeperModel) {
		$this->gatekeeperModel = $gatekeeperModel;

		$this->welcomeMessage = false;
	}

	public function getUsername() {
		return $_POST[self::$name];
	}

	public function getPassword() {
		return $_POST[self::$password];
	}

	public function enableWelcomeMessage() {
		$this->welcomeMessage = true;
	}

	public function userTriesToLogIn() {
		return isset($_POST[self::$login]);
	}

	public function userTriesToLogOut() {
		return isset($_POST[self::$logout]);
	}

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		if ($this->gatekeeperModel->isLoggedIn())
		{
			return $this->generateLogoutButtonHTML();
		}

		return $this->generateLoginFormHTML();
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML() {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->getWelcomeMessage() . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML() {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->getErrorMessages() . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	private function getWelcomeMessage() {
		if ($this->welcomeMessage)
		{
			return 'Welcome';
		}
		
		return '';
	}

	private function getErrorMessages() {
		return $this->gatekeeperModel->getErrorMessage();
	}

	private function getRequestUserName() {
		return $this->gatekeeperModel->getUsername();
	}
	
}
