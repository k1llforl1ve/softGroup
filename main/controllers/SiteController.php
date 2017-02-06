<?php
!defined(ROOT_PATH) || die('Config not included');
include_once ROOT_PATH.'models/Comments.php';
include_once ROOT_PATH . 'controllers/Controller.php';
class SiteController extends Controller
{
    function __construct(){
      

    }
    function actionIndex(){
       $data ='S';
        return $this->render('index',$data);
    }
}
