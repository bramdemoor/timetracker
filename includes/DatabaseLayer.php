<?php

function __autoload($class_name) {
    include $class_name . '.php';
}

class DatabaseLayer extends DatabaseConnection
{
    private static $m_pInstance;

    public static function getInstance()
    {
        if (!self::$m_pInstance)
        {
            self::$m_pInstance = new DatabaseLayer();
        }

        return self::$m_pInstance;
    }

    public function __construct() {
        parent::__construct();
    }

    public function hostInfo() {
        echo self::$mysql->host_info . "\n";
    }

    public function getAllEntries() {
       $result = self::$mysql->query("SELECT * FROM entries", MYSQLI_STORE_RESULT);

       if($result == null)  {
           echo self::$mysql->error;
           exit;
       }

       $returnSet = array();
       while($picksRow = $result->fetch_array(MYSQLI_ASSOC)) {
           array_push($returnSet, $picksRow);
       }

       $result->free();

       return $returnSet;
    }

    public function insertTask($task, $start) {
        self::$mysql->query("INSERT INTO entries (Task, Start) VALUES ('". $task ."', '". date("Y-m-d H:i:s", $start) ."')");
        self::$mysql->commit();
    }

    public function updateTaskDescription($id, $task) {
        self::$mysql->query("UPDATE entries SET Task='". $task ."' WHERE Id='". $id ."'");
        self::$mysql->commit();
    }

    public function deleteEntry($id) {
        self::$mysql->query("DELETE from entries WHERE Id='". $id ."'");
        self::$mysql->commit();
    }

    public function getDistinctItems() {
        $result = self::$mysql->query("SELECT DISTINCT Task FROM entries", MYSQLI_STORE_RESULT);

        if($result == null)  {
            echo self::$mysql->error;
            exit;
        }

        $returnSet = array();
        while($picksRow = $result->fetch_array(MYSQLI_ASSOC)) {
            array_push($returnSet, $picksRow);
        }

        $result->free();

        return $returnSet;
    }
}
