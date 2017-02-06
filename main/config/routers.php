<?php
return array(

    'comments' => 'comments/index', //CommentsController.php->actionIndex
    'ajax/s' => 'ajax/index', //AjaxController.php->actionIndex
    'login/logout' => 'login/logout', //LoginController.php->actionLogout
    'login/login' => 'login/login', //LoginController.php->actionLogin
    'login/register' => 'login/register', //LoginController.php->actionIndex
    'ajax/create' => 'ajax/create', //AjaxController.php->actionCreate
    'ajax/edit' => 'ajax/edit', //AjaxController.php->actionCreate
    'ajax/delete' => 'ajax/delete', //AjaxController.php->actionDelete
    'ajax/vote' => 'ajax/vote', //AjaxController.php->actionVote
    'ajax/refresh' => 'ajax/refresh', //AjaxController.php->actionVote
    '^soft$'=> 'site/index'  // mainPage
);