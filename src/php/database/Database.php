<?php

namespace Database;

use PDO;

interface Database
{
    public static function connect(): void;

    public static function disconnect(): void;

    public static function isConnected(): bool;

    public static function getConnection(): PDO;
}
