<?php
include_once ROOT_PATH . 'models/Model.php';

class Session extends Model
{
    /**
     * Инициализация сессии
     */
    public static function init()
    {
        @session_start();
        
    }
    //удаляем сессию
    public static function destroy() {

        session_destroy();
    }
    // Сэттер сессии
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    // Getter
    public static function get($key) {
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];
    }

    /**
     * Провека на существование сессии для активного сеанса
     * @return bool
     */
    public static function is_session_started()
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        
        return FALSE;
    }

}