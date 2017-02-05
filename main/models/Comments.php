<?php

include_once ROOT_PATH . 'models/Model.php';

class Comments extends Model
{


    public function getCommentsCount($where= 'where active = 1', $threadId = '')
    {

        if ($threadId) {
            $res = $this->db->query("SELECT COUNT(*) FROM comments where parent = {$threadId} and active = 1");
        } else {
            $res = $this->db->query("SELECT COUNT(*) FROM comments {$where}");
        }

        return $res->fetchColumn();
    }

    public function getAllComments()
    {
        $res = $this->db->query('SELECT * FROM  `comments` WHERE active = 1');
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $data = $res->fetchAll();

        return $data;
    }

    public function createComment($properities)
    {
        $data = $this->prepareDataforCreate($properities);

        $q = $this->db->prepare("INSERT INTO `comments` ({$data['keys']}) VALUES ({$data['values']})");
        return $q->execute();
    }
    
  
}

