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
	private $requestModel;
	private $cookieModel;

	private $message;

	private $inputUsername;

	public function __construct($gatekeeperModel) {
		$this->gatekeeperModel = $gatekeeperModel;
		$this->requestModel = new \model\RequestModel();
		$this->cookieModel = new \model\CookieModel();
	}

	public function userTriesToLogIn() {
		return $this->requestModel->get(self::$login) !== null;
	}

	public function userTriesToLogOut() {
		return $this->requestModel->get(self::$logout) !== null;
	}

	public function userWantsToBeRemembered() {
		return $this->requestModel->get(self::$keep) !== null;
	}

	// public function getRequestUsername() {
	// 	return $this->requestModel->get(self::$name);
	// }

	// public function getRequestPassword() {
	// 	return $this->requestModel->get(self::$name);
	// }

	public function getCookieUsername() {
		return $this->cookieModel->get(self::$cookieName);
	}

	public function getCookiePassword() {
		return $this->cookieModel->get(self::$cookiePassword);
	}

	public function setCookie(\model\UserCredentials $userCredentials) {
		$username = $userCredentials->getUsername();
		$tempPassword = $userCredentials->getTempPassword();
		$timeout = $userCredentials->getTimeout();

		$this->cookieModel->set(self::$cookieName, $username, $timeout);
		$this->cookieModel->set(self::$cookiePassword, $tempPassword, $timeout);
	}

	public function removeCookie() {
		$this->cookieModel->set(self::$cookieName, null, time() - 3600);
		$this->cookieModel->set(self::$cookiePassword, null, time() - 3600);
	}

	public function setInputUsername($inputUsername) {
		$this->inputUsername = $inputUsername;
	}

	public function getUserCredentials() {
		$userCredentials = null;

		try {
			$username = $this->requestModel->get(self::$name);
			$password = $this->requestModel->get(self::$password);

			$userCredentials = new \model\UserCredentials($username, $password);
		}
		catch (\Exception\UsernameMissingException $exception) {
			$this->message = 'Username is missing';
		}
		catch (\Exception\PasswordMissingException $exception) {
			$this->message = 'Password is missing';
		}

		return $userCredentials;
	}

	public function enableWelcomeMessage() {
		if ($this->userWantsToBeRemembered()) {
			$this->message = 'Welcome and you will be remembered';
		}
		else {
			$this->message = 'Welcome';
		}
	}

	public function enableWrongCredentialsMessage() {
		$this->message = 'Wrong name or password';
	}

	public function enableWelcomeMessageCookie() {
		$this->message = 'Welcome back with cookie';
	}

	public function enableWrongCredentialsMessageCookie() {
		$this->message = 'Wrong information in cookies';
	}

	public function enableByeMessage() {
		$this->message = 'Bye bye!';
	}

	public function enableRegisteredMessage() {
		$this->message = 'Registered new user.';
	}

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$response = '';

		if ($this->gatekeeperModel->isLoggedIn()) {
			$response .= $this->generateLogoutButtonHTML();
			$response .= $this->generateUsernameList();
		}
		else {
			$response .= $this->generateLoginFormHTML();
			$response .= $this->generateEmptyUsernameList();
		}

		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML() {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->message . '</p>
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
			<form method="post" action="?"> 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->requestModel->get(self::$name) . $this->inputUsername . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	private function generateEmptyUsernameList() {
		return '
			<h2>List of users</h2>
			<p>You are not logged in. Log in to see a list of all users.</p>
		';
	}

	private function generateUsernameList() {
		$usernames = $this->gatekeeperModel->getListOfUsernames();
		$usernamesList = '';
		foreach ($usernames as $username) {
			$usernamesList .= '<li>' . $username . '</li>';
		}

		return '
			<h2>List of users</h2>
			<ul>
				' . $usernamesList . '
			</ul>
		';
	}
	
}
