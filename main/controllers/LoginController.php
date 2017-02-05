<?php
!defined(ROOT_PATH) || die('Config not included');
include_once ROOT_PATH . 'models/Login.php';
include_once ROOT_PATH . 'models/Session.php';
include_once ROOT_PATH . 'controllers/Controller.php';

class LoginController extends Controller
{
    public $user;

    public function __construct()
    {

        if (Session::get('loggedIn') != false && Session::get('userId')) {
            $login = new Login();
            $this->user = $login->getUser(Session::get('userId'));
        } else {
            $this->user = 0;
        }
    }

    public function getId($sessionId)
    {
        return $this->getId($sessionId);
    }

    public function actionLogin()
    {
        if (isset($_REQUEST['user']) && isset($_REQUEST['user']))
            $login = new Login();
        $user = $login->LoginIn();
    }

    public function actionLogout()
    {
        $_SESSION = array();
        Session::destroy();
        header('Location:' . SITE_URL . 'comments');
    }
}