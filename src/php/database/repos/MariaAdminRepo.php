<?php

namespace Database\Repos;

use Database\Database;
use Database\DAOs\MarkerDAO;
use PDO;
include_once 'AdminRepo.php';

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
    public function registerAdmin($username, $password){
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
        self::$database::getConnection()->query("INSERT INTO admin (username, passwordHash) 
            VALUES ($username, $passwordHashed) ON duplicate KEY UPDATE username=$username, passwordHash=$passwordHashed;");
    }
}
