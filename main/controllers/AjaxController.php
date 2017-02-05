<?php
require(dirname(dirname(__FILE__)) . '/config/config.php');
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
   public function actionCreate($data='')
   {
       if (!$data) $data = $_REQUEST;
       $data['createdon'] = time();
       include_once ROOT_PATH.'controllers/CommentsController.php';
       $comments = new Comments();
       return $comments->createComment($data);

   }
//    public function actionIndex($data = '')
//    {
//        if ($this->checkAjax() === false) echo 'Nope, Something wrong with AjaxController.php with ajax';
//        if (!$data) $data = $_REQUEST;
//        print_r($data);
//
//    }
}