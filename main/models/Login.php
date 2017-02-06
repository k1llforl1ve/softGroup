<?php

include_once ROOT_PATH . 'models/Model.php';

class Login extends Model
{
    public $id;

    public function __construct()
    {
        parent::__construct();
        $this->id = 0;
        if (isset($_SESSION['userId'])) {
            $this->id = $_SESSION['userId'];
        }
    }
    /*
     * Получаем айди текущего пользователя(нужно сделать, что если пользователь анноним - то айди 0). Пока это в плнанах
     */
    public static function getId()
    {
        $id = 0;
        if (isset($_SESSION['userId'])) {
            $id = $_SESSION['userId'];
        }
        return $id;
    }

    /**
     * обычный Getter необходимого поля из юзеров
     * @param $para
     * @return mixed
     */
    public function get($para)
    {
        $q = $this->db->prepare("SELECT $para FROM users WHERE id = :id");
        $q->execute(array(
            ':id' => $this->id,
        ));
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $data = $q->fetchAll();
        return($data[0][$para]);
    }

    /**
     * Создаем пользователя
     * @param $properities
     */
    public function createUser($properities)
    {
        /*
         * Обработка необходимых параметров для создания юзера
         */
        $data = $this->prepareDataforCreate($properities);

        $q = $this->db->prepare("INSERT INTO `users` ({$data['keys']}) VALUES ({$data['values']})");
        print_r($q->execute());
    }
    // Трэш функция, нужно переделать, сейчас она при логи записывает в массив $_SESSION его айди и параметры, для дальнейшей работы. Рефакторинг  в первую очередь
    public function getUser($userId)
    {
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
     * Проверка логина и пароля в pdo
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
        // Если найден юзер, инициализация сессии, присвоение массиву $_SESSION необходимых параметров и переадресации
        if ($count > 0) {
            Session::init();
            Session::set('loggedIn', true);
            Session::set('userId', $data[0]['id']);
            Session::set('user', $data[0]);
            header('Location:' . SITE_URL . 'comments');
        } else {
            header('Location:' . SITE_URL . 'comments/?log=err');
        }
    }
}