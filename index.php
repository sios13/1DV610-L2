<?php

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// REQUIRE EVERYTHING
require_once('src/Service.php');
require_once('src/Router.php');
require_once('src/Controller.php');
require_once('src/View.php');

require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/LayoutView.php');

require_once('controller/IndexController.php');


$service = new lab2\Service();

// ADD ROUTES
$router = $service->getService('router');
$router->addService($service);
$router->addRoute('/', 'IndexController', 'indexAction');
$router->addRoute('/register', 'IndexController', 'registerAction');
$router->route();

// $view = $service->getService('view');
// $view->setLayout('LayoutView.php');
