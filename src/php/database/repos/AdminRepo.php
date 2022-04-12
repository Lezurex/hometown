<?php

namespace Database\Repos;

interface AdminRepo
{
    public function getCredentials($username): array;
    public function registerAdmin($username, $password);
}