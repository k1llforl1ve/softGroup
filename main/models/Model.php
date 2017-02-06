<?php

class Model
{

    public $db;

    public function __construct()
    {
        $this->db = Model::getDbConnection();
    }

    /**
     * Тривиальное подключение к базе
     * @return PDO
     */
    public static function getDbConnection()
    {
        require(dirname(dirname(__FILE__)) . '/config/config.php');

        $dsn = "mysql:host={$database_server};dbname={$dbase};charser={$database_connection_charset}";
        $db = new PDO($dsn, $database_user, $database_password);
        return $db;
    }

    /**
     * Получаем и обрабатываем данные(преобразуем массив в 2 строки со значениями и ключами)
     * Необходимые для get и set функций для SQL запроса на UPDATE
     * @param $data
     * @param string $dataPreset
     * @return mixed
     */
    public function prepareDataforCreate($data,$dataPreset='')
    {
        // если есть необходимый шаблон(пресет) необходимого массива на выходе
        // Сделано, чтобы убирать SessionId, Q из $_REQUEST
        if ($dataPreset != '')
        {
            $data = array_intersect_key  ($data, $dataPreset);
        }
        if (!$data) die('Data wasnt set in prepareDataforCreate Model');
        foreach ($data as $key => $value) {
            $output['keys'][] = "`" . htmlspecialchars($key) . "`";
            $output['values'][] = "'".htmlspecialchars($value)."'";

        }
        $output['keys'] = implode(',', $output['keys']);
        $output['values'] = implode(',', $output['values']);
        return $output;
    }
    // Получаем название полей в таблице
    public function getTableField($tableName)
    {
        $tableName = htmlspecialchars($tableName);
        $q = $this->db->prepare("DESCRIBE {$tableName}");
        $q->execute();
        $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
        return $table_fields;
    }

}