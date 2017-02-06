<?php

class Model
{

    public $db;

    public function __construct()
    {
        $this->db = Model::getDbConnection();
    }
    public static function getDbConnection()
    {
        require(dirname(dirname(__FILE__)) . '/config/config.php');

        $dsn = "mysql:host={$database_server};dbname={$dbase};charser={$database_connection_charset}";
        $db = new PDO($dsn, $database_user, $database_password);
        return $db;
    }
    public function prepareDataforCreate($data,$dataPreset='')
    {
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
    public function getTableField($tableName)
    {
        $tableName = htmlspecialchars($tableName);
        $q = $this->db->prepare("DESCRIBE {$tableName}");
        $q->execute();
        $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
        return $table_fields;
    }

}