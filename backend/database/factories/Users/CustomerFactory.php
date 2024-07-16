<?php

namespace Database\Factories\Users;

use App\Services\CartService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function createCustomerWithRole()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'role' => 'customer',
        ];

        $service = new UserService();
        return $service->createUser($userData);
    }

    public function createCustomerWithRoleAndCart()
    {
        $user = $this->createCustomerWithRole();
        (new CartService())->createCartForUser($user);

        return $user;
    }
}
