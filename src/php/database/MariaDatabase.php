<?php

namespace Database;

use PDO;

class MariDatabase implements Database
{
  private static $host = "db";
  private static $username = "root";
  private static $password = "root";
  private static $database = "hometown";
  private static $port = 3306;
  private static PDO $connection;

  public static function connect(): void
  {
    self::$connection = new PDO(self::buildConnectionString(), self::$username, self::$password);
  }

  public static function disconnect(): void
  {
    if (self::isConnected()) {
      self::$connection = null;
    }
  }

  public static function isConnected(): bool
  {
    return self::$connection != null;
  }

  public static function getConnection(): PDO
  {
    return self::$connection;
  }

  private static function buildConnectionString(): string
  {
    return "mysql:host=" . self::$host . "port=" . self::$port . "dbname=" . self::$database;
  }
}
