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
        $result = self::$database::getConnection()->query("SELECT passwordHash FROM admin
                    WHERE username = $username");
        return $result->fetch();
    }

    public function registerAdmin($username, $password)
    {
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = self::$database::getConnection()->prepare("INSERT INTO admin (username, passwordHash) 
            VALUES (:username, :password) ON duplicate KEY UPDATE username=:username, passwordHash=:password;");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':passwordHash', $passwordHashed);
    }
}
