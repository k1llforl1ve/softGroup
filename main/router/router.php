<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 31.01.2017
 * Time: 22:45
 */
class Router
{
    private $routes;
     /**
     * @return mixed
     */
    public function __construct()
    {
        $routesP = ROOT_PATH. 'config/routers.php';
        $this->routes = include ($routesP);
    }

    /**
     * @return string
     */

    private function getUri(){
        if (!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        return 'Юрі не отриманий';
    }
    /**
     *
     */
    public function run()
    {
        require(ROOT_PATH. 'controllers/MiddleController.php');
        $middleController = new MiddleController();

        $uri = $this->getUri();
        foreach($this->routes as $uriTemplate => $path){
            if (preg_match("~$uriTemplate~",$uri)){
                $s = explode('/',$path);

                $controllerName = array_shift($s);
                $controllerName = ucfirst($controllerName).'Controller';
                $actionName = 'action'.ucfirst(array_shift($s));

                $contollerFile = ROOT_PATH.'/controllers/'.$controllerName.'.php';
                //Підключення класа
                if (file_exists($contollerFile)){
                    include_once ($contollerFile);
                }
                // Создаєм екземпляр класса
                $controllerObject = new $controllerName;
                $res = $controllerObject->$actionName();
                // Якщо знайшли необхідний метод
                if ($res != null){
                    break;
                }
            }
        }
    }
}