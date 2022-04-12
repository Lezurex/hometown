<?php

namespace Database\Repos;

use Database\Database;
use Database\DAOs\MarkerDAO;
use PDO;

class MariaAdminRepo implements AdminRepo
{

    private static Database $database;

    public function __construct(Database $database)
    {
        self::$database = $database;
    }

    public function getCredentials($username): array
    {
        $result = self::$database::getConnection()->query("SELECT passwordHash FROM ADMIN
                    WHERE username = $username");
        return $result->fetch();
    }
}
