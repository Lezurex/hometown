<?php
namespace Database;

use PDO;

class Database
{
    private static $host = "db";
    private static $username = "root";
    private static $password = "root";
    private static $database = "hometown";
    private static $connection;


    public static function connect()
    {
        self::$connection = new pdo(self::$host, self::$username, self::$password, self::$database);
    }

    public static function disconnect()
    {
        if (self::isConnected()) {
            mysqli_close(self::$connection);
        }
    }

    public static function isConnected()
    {
        return self::$connection != null;
    }

    public static function getConnection()
    {
        return self::$connection;
    }
}
?>
