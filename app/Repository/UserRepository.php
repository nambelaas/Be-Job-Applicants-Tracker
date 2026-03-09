<?php

namespace App\Service;

use App\Models\User;
use App\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create($data)
    {
        return User::create($data);
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}
