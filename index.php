<?php
session_start();

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// REQUIRE EVERYTHING
require_once('Exceptions.php');

require_once('model/RequestModel.php');
require_once('model/SessionModel.php');
require_once('model/CookieModel.php');
require_once('model/DatabaseModel.php');
require_once('model/GatekeeperModel.php');
require_once('model/UserCredentials.php');

require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/LayoutView.php');

require_once('controller/MasterController.php');
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');

// START APPLICATION
$gatekeeperModel = new \model\GatekeeperModel(new \model\DatabaseModel());
$layoutView = new \view\LayoutView($gatekeeperModel);

$masterController = new \controller\MasterController($gatekeeperModel, $layoutView);
$masterController->handleRequest();

$htmlBody = $layoutView->generateOutput();
$layoutView->render($htmlBody);
