<?php

include_once ROOT_PATH . 'models/Model.php';

class Comments extends Model
{


    public function getCommentsCount($where= 'where active = 1', $threadId = false)
    {

        if ($threadId) {
            $res = $this->db->query("SELECT COUNT(*) FROM comments where parent = {$threadId} and active = 1");
        } else {
            $res = $this->db->query("SELECT id,parent FROM comments {$where}");
        }
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $data = $res->fetchAll();
        if (!$data && !empty($data)) return 0;
        // TODO: знайти інший варіант пошуку валідності коментаря(якщо існує батько), наприклад через побудову дерева ресурсів
        foreach ($data as $iten)
        {
            $a[] = $iten['id'];
            $b[] = $iten['parent'];
        }
        // TODO: перенести в свойство( с проверками и т.д). Идея, все деларжать в MiddleController Или другом месте и обращаться через $this->middleco->comments

        include_once ROOT_PATH . 'controllers/CommentsController.php';
        $comments = new Comments();
        foreach($data as $item)
        {
            if (in_array($item['parent'],$a) || $item['parent'] == 0) {
                $ids[] = $item['id'];
            }
            else{
                $comments->delete($item['id']);
            }
        }

        return count($ids);
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

        $res = $this->db->query('SELECT * FROM  `comments` WHERE active = 1 and parent = 0 ORDER BY id DESC');
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $data = $res->fetchAll();
        
        return $data;
    }

    public function createComment($properities)
    {
        $table_fields = $this->getTableField('comments');

        $data = $this->prepareDataforCreate($properities,array_flip($table_fields));

        $q = $this->db->prepare("INSERT INTO `comments` ({$data['keys']}) VALUES ({$data['values']})");

        return $q->execute()==1?'User was created':'User wasnt created';
    }
    public static function getStars($commentId,$userId ='')
    {
        if($userId == '')
        {
            $login = new Login();
            $userId =$login->getId();
        }

        $db = parent::getDbConnection();
        $res = $db->prepare('SELECT value FROM  `comments_votes` WHERE comment_id = :com_id and createdby = :usr_id');
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $res->execute(array(
            ':com_id' => $commentId,
            ':usr_id' => $userId,

        ));
        $data = $res->fetchAll();
//        print_r($data[0]['value']);
        if ($data){print_r ($data[0]['value']);}
        return 0;

    }
    public static function getAvgStars($commentId)
    {
        $db = parent::getDbConnection();
        $res = $db->prepare('SELECT value FROM  `comments_votes` WHERE comment_id = :com_id');
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $res->execute(array(
            ':com_id' => $commentId,

        ));
        $data = $res->fetchAll();
        if (!$data){ print_r( 0); return true;}
        foreach($data as $item)
        {
            $scores[] = $item['value'];
        }

//        print_r($data[0]['value']);
        print_r( round (array_sum($scores)/count($scores),2));
//        return '1';
    }
    public static function getCommentChilds($commentId)
    {
        $db = parent::getDbConnection();
        $res = $db->prepare('SELECT * FROM  `comments` WHERE parent = :com_id');
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $res->execute(array(
            ':com_id' => $commentId,

        ));
        $data['output'] = $res->fetchAll();
        if (!$data['output']){  return true;}
        ob_start();
        if ($data['output']) {
            require ROOT_PATH . 'views/Comments/tpls/Comments.php';
        }
        $data['comments'] =  ob_get_clean();

        print_r( $data['comments']);
    }
}

