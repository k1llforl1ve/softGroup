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
    /**
     * Обработка псевдо аякс запроса( не проходит проверку на аяксоность, и даже не можеть "вернуть" - return не работает)
     * Создаем комментарий и получаем сразу список всех комментариев и их количество(для аякса)
     * @param string $data
     */
    public function actionCreate($data = '')
    {
        if (!$data) $data = $_REQUEST;
        // Дата создание коммента в UNIX
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
        $output['countcom'] = $comments->getCommentsCount();
        print_r(json_encode($output));

    }

    /**
     * Редактирование комментария, аякс запрос, возваращаем json массив
     * @param string $data
     */
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

    /**
     * Удаление коммента с проверкой юзера на возможность удалить коммент
     * TODO: расширить: проверка или это админ, чтобы удалить, проверить или это человек создавший ветвь комментариев и т.д
     * @param string $data
     * @return bool
     */


    public function actionDelete($data = '')
    {
        if (!$data) $data = $_REQUEST;
        $output['message'] = 'Something went wrong with AjaxController actionDelete';
        $data['editedon'] = time();
        include_once ROOT_PATH . 'controllers/CommentsController.php';
        $comments = new Comments();
        $login = new Login();
        if ($login->id != $data['createdby'] )  return false;
        if ($comments->delete($data['commentid'])) $output['message'] = 'everything is ok';

        $output['countcom'] = $comments->getCommentsCount();
        print_r(json_encode($output));
    }

    /**
     * Аякс запрос на голосование, добавляем UNIX время создание строчки в бд(голоса)
     * @param string $data
     */
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
    /**
     * Ajax обновление всех комментов в шаблонизаторе. Возвращаем json c количеством и самими комментами
     */

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