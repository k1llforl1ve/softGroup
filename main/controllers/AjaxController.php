<?php
require(dirname(dirname(__FILE__)) . '/config/config.php');

// TODO: Вынести USER инициализация классов(обекты) в переменные по типу $this->user
class AjaxController
{

//    public function checkAjax()
//    {
//        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')  {
//            /* special ajax here */
//            die('Nope, Something wrong with AjaxController.php with ajax');
//        }
//
//    }
    public function actionCreate($data = '')
    {
        if (!$data) $data = $_REQUEST;
        $data['createdon'] = time();
        include_once ROOT_PATH . 'controllers/CommentsController.php';
        $comments = new Comments();
        $login = new Login();

        $data['createdby'] = $login->getId();
        $data['createdby_name'] = $login->get('login');
        $output['message'] = $comments->createComment($data) == true ? 'Created Succesfully' : 'There is an error in creating';
        $data['output'] = $comments->getAllComments();
        ob_start();
        if ($data['output']) {
            require ROOT_PATH . 'views/Comments/tpls/Comments.php';
        }
        $output['comments'] =  ob_get_clean();
        print_r(json_encode($output));

    }
    public function actionEdit($data = '')
    {
        if (!$data) $data = $_REQUEST;
        $data['editedon'] = time();
        include_once ROOT_PATH . 'controllers/CommentsController.php';
        $comments = new Comments();
        $login = new Login();
       

        $comments->set('body',$data['body'],$data['commentid'],$login->id);
        $comments->set('editedon',$data['editedon'],$data['commentid'],$login->id);

        print_r(json_encode(array('message'=>'everything is ok')));
    }
    public function actionDelete($data = '')
    {
        if (!$data) $data = $_REQUEST;
        $data['editedon'] = time();
        include_once ROOT_PATH . 'controllers/CommentsController.php';
        $comments = new Comments();
        $login = new Login();
        if ($login->id != $data['createdby'])  return false;
        $comments->delete($data['commentid']);

        print_r(json_encode(array('message'=>'everything is ok')));
    }
    public function actionVote($data = '')
    {
        if (!$data) $data = $_REQUEST;
        $data['createdon'] = time();

        include_once ROOT_PATH . 'models/Vote.php';
        $vote = new Vote();
        $vote->vote($data);

    }
//    public function actionIndex($data = '')
//    {
//        if ($this->checkAjax() === false) echo 'Nope, Something wrong with AjaxController.php with ajax';
//        if (!$data) $data = $_REQUEST;
//        print_r($data);
//
//    }
    public function actionRefresh()
    {
        include_once ROOT_PATH . 'controllers/CommentsController.php';
        $Comments = new Comments();
        $data['output'] = $Comments->getAllComments();
        $data['countcom'] = $Comments->getCommentsCount();

        ob_start();
        if ($data['output']) {
            require ROOT_PATH . 'views/Comments/tpls/Comments.php';
        }
        $data['comments'] =  ob_get_clean();
        print_r(json_encode($data));
    }
}