<?php

abstract class DatabaseConnection
{
    protected static $mysql;

    function __construct() {
        if (!isset(self::$mysql)) {
            self::$mysql = new mysqli("localhost", "webuser", "test", "timetracker-dev", "8889");
            if (self::$mysql->connect_errno) {
                echo "Failed to connect to MySQL: (" . $this->mysql->connect_errno . ") " . self::$mysql->connect_error;
            }
        }
    }

    function DisconnectFromDatabase() {
        if (isset($mysql)) {
            mysql_close($mysql);
        } else {
            echo 'Could not close connection. There is no connection to close.';
        }
    }
}
