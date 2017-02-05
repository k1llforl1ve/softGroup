<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 31.01.2017
 * Time: 0:15
 */
$database_type = 'mysql';
$database_server = 'kifa.mysql.ukraine.com.ua';
$database_user = 'kifa_soft';
$database_password = '4242yk7j';
$database_connection_charset = 'utf8';
$dbase = 'kifa_soft';
if (!defined('DB_NAME')) {
    define('DB_NAME', 'kifa_soft');
}
if (!defined('ROOT_PATH')) {
    $root_apth= '/home/kifa/123456.com.ua/www/soft/main/';
    define('ROOT_PATH', $root_apth);
}
if (!defined('CORE_PATH')) {
    $core_path= '/home/kifa/123456.com.ua/www/soft/';
    define('CORE_PATH', $core_path);
}
if (!defined('SITE_URL')) {
    $site_url= "http://123456.com.ua/soft/";
    define('SITE_URL', $site_url);
}
return array('database_type'=>'test');