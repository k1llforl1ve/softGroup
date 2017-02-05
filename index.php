<?php
/* include custom main config and define main path */
error_reporting(E_ALL);
ini_set('display_errors', 1);
setlocale(LC_ALL, 'uk_UA.UTF-8');
require (dirname(__FILE__) . '/main/config/config.php');
require ROOT_PATH.'models/Session.php';

//include(ROOT_PATH. 'controllers/CommentsController.php');
include(ROOT_PATH. 'router/router.php');
Session::init();
$router = new Router();
$router->run();