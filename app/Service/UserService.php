<?php

namespace App\Service;

use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function registerUser($data)
    {
        $data['password'] = bcrypt($data['password']);

        try {
            $user = $this->userRepository->create($data);
        } catch (\Exception $e) {
            return [
                'error' => 'Failed to register user',
                'message' => $e->getMessage()
            ];
        }

        return [
            'message' => 'User registered successfully',
            'token' => $user->createToken(
                'auth_token',
                ['*'],
                now()->addMinutes(15)
            )->plainTextToken
        ];
    }

    public function loginUser($data)
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'error' => 'Invalid credentials',
                'message' => 'The provided credentials are incorrect.'
            ];
        }

        return [
            'message' => 'User logged in successfully',
            'token' => $user->createToken(
                'auth_token',
                ['*'],
                now()->addMinutes(15)
            )->plainTextToken
        ];
    }
}
