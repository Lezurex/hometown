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
        $stmt = self::$database::getConnection()->prepare("SELECT passwordHash FROM admin WHERE username = :username;");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
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
