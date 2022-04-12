<?php

namespace Database\Repos;

interface AdminRepo
{
    public function getCredentials($username): array;
}