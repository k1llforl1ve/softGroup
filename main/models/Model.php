<?php

class Model
{

    protected $db;

    public function __construct()
    {
        $this->db = Model::getDbConnection();
    }
    public static function getDbConnection()
    {
        require(dirname(dirname(__FILE__)) . '/config/config.php');

        $dsn = "mysql:host={$database_server};dbname={$dbase}";
        $db = new PDO($dsn, $database_user, $database_password);
        return $db;
    }

}