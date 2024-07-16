<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Users\Customer;
use App\Models\Users\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProductionCreationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_create_product_with_valid_data()
    {
        $supplierUser = Supplier::factory()->createSupplierWithRole();

        $data = [
            'name' => 'Test Product',
            'price' => 99.99,
            'quantity' => 10,
            'description' => 'A test product description',
        ];

        $response = $this->actingAs($supplierUser)->postJson('/api/product', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'name',
            'price',
            'description',
            'created_at',
        ]);

        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_create_product_with_customer_user()
    {
        $customerUser = Customer::factory()->createCustomerWithRole();

        $data = [
            'name' => 'Test Product',
            'price' => 99.99,
            'quantity' => 10,
            'description' => 'A test product description',
        ];

        $response = $this->actingAs($customerUser)->postJson('/api/product', $data);

        $response->assertStatus(403);
    }

    public function test_create_product_with_invalid_data()
    {
        $supplierUser = Supplier::factory()->createSupplierWithRole();

        $data = [
            'name' => 'Test ProductTest ProductTest ProductTest ProductTest ProductTest ProductTest ProductTest ProductTest Product',
            'price' => 'thirty',
            'quantity' => 'thirty',
            'description' => '',
        ];

        $response = $this->actingAs($supplierUser)->postJson('/api/product', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'price', 'quantity']);
    }
}
