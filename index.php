<?php
/* include custom main config and define main path */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require (dirname(__FILE__) . '/main/config/config.php');
require ROOT_PATH.'models/Session.php';
Session::init();
print_r($_SESSION);
//include(ROOT_PATH. 'controllers/CommentsController.php');
include(ROOT_PATH. 'router/router.php');

$router = new Router();
$router->run();