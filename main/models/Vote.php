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


    public function vote($data)
    {
        $login = new Login();
        $userId = $login->getId();
        $data['createdby'] = $userId;
        $table_fields = $this->getTableField('comments_votes');
            print_r($this->checkVote($data['comment_id'], $userId));
        if ($this->checkVote($data['comment_id'], $userId) > 0) {
            $this->updateVote($data['comment_id'], $userId,$data['value']);
            return 'Updated';
        }

        $data = $this->prepareDataforCreate($data, array_flip($table_fields));

        $q = $this->db->prepare("INSERT INTO `comments_votes` ({$data['keys']}) VALUES ({$data['values']})");
        return ($q->execute());
    }

    public function updateVote($commentId, $userId,$value)
    {
        $q = $this->db->prepare("UPDATE  comments_votes SET  value = '{$value}' WHERE  comment_id = :id and createdby = :userid");
        $q->execute(array(
            ':id' => $commentId,
            ':userid' => $userId,
        ));
        return true;
    }

    public function checkVote($commentId, $userId)
    {
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