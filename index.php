<?php

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// REQUIRE EVERYTHING
require_once('src/Application.php');
require_once('src/Database.php');

require_once('model/UserModel.php');

require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/LayoutView.php');

require_once('controller/IndexController.php');

// START APPLICATION
$application = new lab2\Application();

$application->addRoute('/', 'IndexController', 'indexAction');
$application->addRoute('/register', 'IndexController', 'registerAction');

$application->handleRequest();
