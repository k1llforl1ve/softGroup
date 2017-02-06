<?php

include_once ROOT_PATH . 'models/Model.php';

class Vote extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->id = 0;
        if (isset($_SESSION['userId'])) {
            $this->id = $_SESSION['userId'];
        }
    }

    /**
     * Голосуем за коммент
     * @param $data
     * @return bool|string
     */
    public function vote($data)
    {
        $login = new Login();
        $userId = $login->getId();
        $data['createdby'] = $userId;


//        print_r($this->checkVote($data['comment_id'], $userId));
        //Проверяем или голосовал юзер, если да - обновляем оценку
        if ($this->checkVote($data['comment_id'], $userId) > 0) {
            $this->updateVote($data['comment_id'], $userId,$data['value']);
            return 'Updated';
        }
        //Получаем поля из базы, для нашей таблицы, для того чтобы сделать array_intersect - удалим лишний мусор и оставим необходимые поля для создание комментраия
        $table_fields = $this->getTableField('comments_votes');
        $data = $this->prepareDataforCreate($data, array_flip($table_fields));

        $q = $this->db->prepare("INSERT INTO `comments_votes` ({$data['keys']}) VALUES ({$data['values']})");
        return ($q->execute());
    }

    /**
     * Обновление оценки комментарию
     * @param $commentId
     * @param $userId
     * @param $value
     * @return bool
     */
    public function updateVote($commentId, $userId,$value)
    {
        $q = $this->db->prepare("UPDATE  comments_votes SET  value = '{$value}' WHERE  comment_id = :id and createdby = :userid");
        $q->execute(array(
            ':id' => $commentId,
            ':userid' => $userId,
        ));
        return true;
    }

    /**
     * Проверка или юзер голосовал
     * @param $commentId
     * @param $userId
     * @return string
     */
    public function checkVote($commentId, $userId)
    {
        //Получаем айди активного юзера
        if ($userId == '') {
            $login = new Login();
            $userId = $login->getId();
        }

        $res = $this->db->prepare('SELECT COUNT(*) FROM  `comments_votes` WHERE comment_id = :com_id and createdby = :usr_id');
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $res->execute(array(
            ':com_id' => $commentId,
            ':usr_id' => $userId,

        ));
        return $res->fetchColumn();
    }

}