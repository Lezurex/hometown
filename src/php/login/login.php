<?php

namespace Login;

include_once '../database/repos/MariaAdminRepo.php';
include_once '../database/MariaDatabaseImpl.php';

use Database\MariaDatabaseImpl;
use Database\Repos\MariaAdminRepo;

session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$adminRepo = new MariaAdminRepo(new MariaDatabaseImpl());
$passwordHash_db = $adminRepo->getCredentials($username)[0];
if ($passwordHash_db !== null && password_verify($password, $passwordHash_db)) {
    echo "proceed";
    $_SESSION['username'] = $_POST['username'];
    exit();
}
echo "unauthorized";
