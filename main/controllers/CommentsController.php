<?php
!defined(ROOT_PATH) || die('Config not included');
include_once ROOT_PATH.'models/Comments.php';
include_once ROOT_PATH . 'controllers/Controller.php';
class CommentsController extends Controller
{
    function actionIndex(){
        $Comments = new Comments();
        $data['output'] = $Comments->getAllComments();
        $data['commentscount'] = $Comments->getCommentsCount('');
        return $this->render('index', $data);
    }
}