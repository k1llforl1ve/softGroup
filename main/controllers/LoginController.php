<?php
!defined(ROOT_PATH) || die('Config not included');
include_once ROOT_PATH.'models/Login.php';
include_once ROOT_PATH . 'models/Session.php';
include_once ROOT_PATH . 'controllers/Controller.php';

class LoginController extends Controller
{
    public function run()
    {
        
        if (Session::is_session_started())
        {
            $login = new Login();
            $user =  $login->getUser();
        }
//        $login = new Login();
//        $user = $login->checkAuthentication();

    }
}