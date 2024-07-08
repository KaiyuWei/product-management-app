<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function createRole(int $userId, string $roleName): User
    {
        $className = "App\\Models\\Users\\" . ucfirst(strtolower($roleName));
        return $className::create(['user_id' => $userId]);
    }

    public function createUserWithRole(array $data): array
    {
        $user = $this->createUser($data);
        $role = $this->createRole($user->id, $data['role']);

        return [
            'role' => $role,
            'user' => $user
        ];
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
