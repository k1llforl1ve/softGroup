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

    /**
     * Возвращает айдишку текущего юзера
     * @param $sessionId
     * @return mixed
     */
    public function getId($sessionId)
    {
        return $this->getId($sessionId);
    }

    /**
     * Обрабатываем логин юзера(лучше сделать обработку на уровне контроллера)
     */
    public function actionLogin()
    {
        if (isset($_REQUEST['user']) && isset($_REQUEST['user'])) {

            $login = new Login();
            $user = $login->LoginIn();
        }
    }
    // TODO: сделать регистрацию с подтверджением
    //Регистрация пользователя
    public function actionRegister()
    {
        $data = '';
        //Если были введены лоогин и пароль то обрабатываем(регистрация)
        if (isset($_REQUEST['user']) && isset($_REQUEST['password']) && isset($_REQUEST['confirm_password'])) {
            if ($_REQUEST['password'] != $_REQUEST['confirm_password']) {
                $data['errors'] = 'passwords doesnt match';
            }
            $login = new Login();
            $login->createUser(array('login' => $_REQUEST['user'], 'password' => md5($_REQUEST['password']), 'date_created' => time()));
            header('Location:' . SITE_URL . 'comments?reg=success');
        }
        //Если нету $_REQUEST log & pass то рендерим форму регистрации
        return $this->render('index', $data);
    }

    /**
     * Убиваем сессии и массив сесий. Функция логаута
     */
    public function actionLogout()
    {
        $_SESSION = array();
        Session::destroy();
        header('Location:' . SITE_URL . 'comments');
    }
}