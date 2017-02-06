<?php
//Подлкючение библиотек(лучше сделать это в прослойке MiddleContoller.php)
!defined(ROOT_PATH) || die('Config not included');
include_once ROOT_PATH . 'models/Comments.php';
include_once ROOT_PATH . 'controllers/Controller.php';

class CommentsController extends Controller
{

    /**
     *  Получаем все комменты, их количествои-> шаблонизатор и на в метод рендеринга view  в template
     */
    function actionIndex()
    {
        $data ='';
        $Comments = new Comments();
        //Все комментарии
        $data['output'] = $Comments->getAllComments();
        //Количество комментариев
        $data['commentscount'] = $Comments->getCommentsCount();
        //Шаблонизатор
        ob_start();
        if ($data['output']) {
            require ROOT_PATH . 'views/Comments/tpls/Comments.php';
        }
        $data['comments'] = ob_get_clean();
        //Рендирнг view из view/Comments(ClassName)/ $1.php
        return $this->render('index', $data);
    }
}