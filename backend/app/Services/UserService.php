<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function findUserByEmail(string $email): User|false
    {
        $user = User::where('email', $email)->first();
        return $user ?? false;
    }

    public function authenticateByEmailAndPassword(string $email, string $inputPassword): string
    {
        $user = $this->findUserByEmail($email);

        if (!$user) {
            throw new \Exception('email not registered', 404);
        }

        $isPasswordValid = Hash::check($inputPassword, $user->password);
        if(!$isPasswordValid) {
            throw new \Exception('password invalid', 401);
        }

        return $user->createToken('user-login')->plainTextToken;
    }
}
