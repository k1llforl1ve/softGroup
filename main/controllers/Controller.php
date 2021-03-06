<?php

class Controller
{
    public $data;
    public function __construct()
    {
    
    }
    //Рендеринг в общий шаблон, необходимых view из папки view/ControllerName/$page_view.php
    public function render($page_view, $data = '', $template_view = "mainTemp.php")
    {
        require(dirname(dirname(__FILE__)) . '/config/config.php');
        $view = ROOT_PATH . 'views/' . str_replace('Controller','',get_class($this)) . '/' . $page_view . '.php'; // get view
        require ROOT_PATH . 'views/' . $template_view;// вывод
    }
}