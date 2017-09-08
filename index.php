<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

// LOAD EVERYTHING
require_once('src/Service.php');
require_once('src/Router.php');
require_once('src/Controller.php');
require_once('controller/IndexController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
// $v = new LoginView();
// $dtv = new DateTimeView();
// $lv = new LayoutView();


// $lv->render(false, $v, $dtv);


$service = new lab2\Service();

// ADD ROUTES
$router = $service->getService('router');
$router->addService($service);
$router->addRoute('/', 'IndexController', 'indexAction');
$router->addRoute('/register', 'IndexController', 'registerAction');
$router->route();
