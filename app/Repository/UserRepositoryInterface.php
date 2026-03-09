<?php

namespace App\Repository;

interface UserRepositoryInterface
{
    public function create($data);
    public function findByEmail($email);
}