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
    // TODO:передалть под человечискую форму сета. Объект должен быть 1 строчкой или всем массивом.
    public function set($para,$value,$id,$userId)
    {
//        print_r("UPDATE  comments SET  $para = '{$value}' WHERE  id = '{$id}' and createdby = '{$userId}'");
        $q = $this->db->prepare("UPDATE  comments SET  $para = '{$value}' WHERE  id = :id and createdby = :userid");
        if ($q->execute(array(
            ':id' => $id,
            ':userid' => $userId,
        ))) return true;

        return false;
    }
    public function delete($para)
    {
//        print_r("UPDATE  comments SET  $para = '{$value}' WHERE  id = '{$id}' and createdby = '{$userId}'");
        $q = $this->db->prepare("DELETE FROM comments WHERE id = :id");
        if ($q->execute(array(
            ':id' => $para,

        ))) return true;

        return false;
    }
    public function getAllComments()
    {

        $res = $this->db->query('SELECT * FROM  `comments` WHERE active = 1 ORDER BY id DESC');
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $data = $res->fetchAll();
        
        return $data;
    }

    public function createComment($properities)
    {
        $q = $this->db->prepare("DESCRIBE comments");
        $q->execute();
        $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);

        $data = $this->prepareDataforCreate($properities,array_flip($table_fields));

        $q = $this->db->prepare("INSERT INTO `comments` ({$data['keys']}) VALUES ({$data['values']})");

        return $q->execute()==1?'User was created':'User wasnt created';
    }
    
  
}

