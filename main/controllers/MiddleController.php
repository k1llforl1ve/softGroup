<?php
//Контроллер отвечающий за прослойку между роутером и уже конечными контроллерами
//Проверка на авторизацию, куки в будущем и т.д
class MiddleController
{
    
    public function __construct()
    {
        include_once ROOT_PATH.'controllers/LoginController.php';
        $login  = new LoginController();

        
    }

}