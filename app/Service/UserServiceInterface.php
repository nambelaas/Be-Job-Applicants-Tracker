<?php

namespace App\Service;

interface UserServiceInterface
{
    public function registerUser($data);
    public function loginUser($data);
}
