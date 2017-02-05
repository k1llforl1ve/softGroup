<?php

include_once ROOT_PATH . 'models/Model.php';

class Login extends Model
{
    public  $id;
    public  function __construct()
    {
        parent::__construct();
        $this->id = 0;
        if (isset($_SESSION['userId'])){
            $this->id = $_SESSION['userId'];
        }
    }

    public static function getId()
    {
        $id = 0;
        if (isset($_SESSION['userId'])){
            $id = $_SESSION['userId'];
        }
        return $id;
    }
    public function get($para)
    {
        $q = $this->db->prepare("SELECT $para FROM users WHERE id = :id");
        $q->execute(array(
            ':id' => $this->id,
        ));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetchAll();
        print_r($data);
    }

    public function getUser($userId)
    {
        print_r($userId);
        $q = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $q->execute(array(
            ':id' => $userId,
        ));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetchAll();
        if ($data) {

            Session::set('userId', $data[0]['id']);
            Session::set('userName', $data[0]['login']);
            Session::set('user', $data[0]);

        }

    }

    /**
     * Login constructor.
     */
    public function LoginIn()
    {
        $q = $this->db->prepare("SELECT id FROM users WHERE login = :login AND password = MD5(:password)");
        $q->execute(array(
            ':login' => $_REQUEST['user'],
            ':password' => $_REQUEST['password']
        ));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetchAll();
        $count = $q->rowCount();
        if ($count > 0) {
            Session::init();
            Session::set('loggedIn', true);
            Session::set('userId', $data[0]['id']);
            header('Location:' . SITE_URL . 'comments');
        } else {
//            header('Location: ../login');
        }
    }
}