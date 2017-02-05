<?php
!defined(ROOT_PATH) || die('Config not included');
include_once ROOT_PATH.'models/Comments.php';
include_once ROOT_PATH . 'controllers/Controller.php';
class CommentsController extends Controller
{
    function actionIndex(){
        $Comments = new Comments();
        $data['output'] = $Comments->getAllComments();
        $data['commentscount'] = $Comments->getCommentsCount();
   
        ob_start();
        if ($data['output']) {
            require ROOT_PATH . 'views/Comments/tpls/Comments.php';
        }
        $data['comments'] =  ob_get_clean();
        return $this->render('index', $data);
    }
}