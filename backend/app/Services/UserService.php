<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function createOriginalUser(array $data): User
    {
        return User::create($data);
    }

    public function createRole(int $userId, string $roleName): User
    {
        $className = "App\\Models\\Users\\" . ucfirst(strtolower($roleName));
        return $className::create(['user_id' => $userId]);
    }

    public function createUser(array $data): User
    {
        if ($this->isUserExisted($data['email'])) throw new \Exception('The email is already registered', 409);

        DB::beginTransaction();
        $user = $this->createOriginalUser($data);
        $role = $this->createRole($user->id, $data['role']);
        DB::commit();

        return $user;
    }

    public function isUserExisted(string $email): bool
    {
        return (bool) $this->findUserByEmail($email);
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
