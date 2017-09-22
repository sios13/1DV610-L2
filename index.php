<?php

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// REQUIRE EVERYTHING
require_once('src/Application.php');

require_once('model/SessionModel.php');
require_once('model/DatabaseModel.php');
require_once('model/GatekeeperModel.php');

require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/LayoutView.php');

require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');

// START APPLICATION
$application = new Application();

$application->addRoute('/', 'LoginController', 'indexAction');
$application->addRoute('/register', 'RegisterController', 'indexAction');

$application->handleRequest();
