<?php

include_once ROOT_PATH . 'models/Model.php';

class Comments extends Model
{


    public function getCommentsCount($where, $threadId = '')
    {
        if ($threadId) {
            $res = $this->db->query("SELECT COUNT(*) FROM comments where parent = {$threadId}");
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
        print_r($q->execute());
    }

    public function prepareDataforCreate($data)
    {
        if (!$data) die('Data wasnt set in CreateComment Action');
        foreach ($data as $key => $value) {
            $output['keys'][] = "`" . htmlspecialchars($key) . "`";
            $output['values'][] = "'".htmlspecialchars($value)."'";

        }
        $output['keys'] = implode(',', $output['keys']);
        $output['values'] = implode(',', $output['values']);
        return $output;
    }
}

