<?php

namespace Database\Factories\Users;

use App\Models\Users\Supplier;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition()
    {
        // Return the factory's default state definition.
        return [
            // Supplier attributes if any
        ];
    }

    public function createSupplierWithRole()
    {
        return $this->state(function (array $attributes, UserService $userService) {
            $userData = [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'supplier'
            ];

            return $userService->createUser($userData);
        });
    }
}
