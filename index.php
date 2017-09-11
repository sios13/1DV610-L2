<?php

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// REQUIRE EVERYTHING
require_once('src/Application.php');
require_once('src/Router.php');
require_once('src/Controller.php');
require_once('src/View.php');
require_once('src/Database.php');
require_once('src/Model.php');

require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/LayoutView.php');

require_once('controller/IndexController.php');

require_once('model/UserModel.php');

$application = new lab2\Application();

$application->createService('router', function() {
    $router = new lab2\Router();
    $router->addRoute('/', 'IndexController', 'indexAction');
    $router->addRoute('/register', 'IndexController', 'registerAction');
    return $router;
});

$application->createService('view', function() {
    return new lab2\View();
});

$application->createService('database', function() {
    return new lab2\Database();
});

$application->handle();

echo $application->getService('view')->getOutput();
