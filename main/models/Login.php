<?php

include_once ROOT_PATH . 'models/Model.php';

class Login extends Model
{
    public function run()
    {
        include_once ROOT_PATH.'controllers/LoginController.php';


    }
    public function checkAuthentication()
    {
       
    }
    public function getUser()
    {
        print_r('11');
        if (Session::get('loggedIn') != false &&  Session::get('userId'))
        {
            $user = $this->db->prepare("SELECT * FROM users WHERE id = {Session::get('userId')}");
            print_r($user);
        }else{
            return false;
        }
    }
    /**
     * Login constructor.
     */
    public function login()
    {
        $q = $this->db->prepare("SELECT id FROM users WHERE login = :login AND password = MD5(:password)");
        $q->execute(array(
            ':login' => $_REQUEST['login'],
            ':password' => $_REQUEST['password']
        ));
        $data = $q->fetchAll();
        $count = $q->rowCount();
        if($count > 0) {
            Session::init();
            Session::set('loggedIn', true);

        } else {
//            header('Location: ../login');
        }
    }
}