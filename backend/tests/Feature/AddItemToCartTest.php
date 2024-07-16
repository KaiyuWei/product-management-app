<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Users\Customer;
use App\Models\Users\Supplier;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AddItemToCartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $customerUser;

    protected $supplierUser;

    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerUser = Customer::factory()->createCustomerWithRoleAndCart();
        $this->supplierUser = Supplier::factory()->createSupplierWithRole();

        $data = [
            'name' => $this->faker->company,
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'description' => $this->faker->text(200),
            'quantity' => 100
        ];

        $this->product = (new ProductService())->createProductForSupplier($data, $this->supplierUser);
    }

    public function test_add_item_in_cart_for_current_user_success()
    {
        $payload = [
            'productId' => 1,
            'quantity' => 2,
            'unitPrice' => 100.00,
        ];

        $response = $this->actingAs($this->customerUser)->postJson('/api/cart/add', $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success'
        ]);

        // Assert the item was added to the cart
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $this->customerUser->roleInstance->cart->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
            'item_price' => 200.00,
        ]);
    }

    public function test_add_item_in_cart_for_current_user_validation_error()
    {
        $payload = [
            'productId' => null,
            'quantity' => -2,
            'unitPrice' => -10,
        ];

        $response = $this->actingAs($this->customerUser)->postJson('/api/cart/add', $payload);

        $response->assertStatus(422); // Unprocessable Entity for validation errors
        $response->assertJsonValidationErrors(['productId', 'quantity', 'unitPrice']);
    }

    public function test_add_item_in_cart_for_current_user_unauthenticated()
    {
        $payload = [
            'productId' => 1,
            'quantity' => 2,
            'unitPrice' => 100.00,
        ];

        $response = $this->postJson('/api/cart/add', $payload);

        $response->assertStatus(401);
    }

    public function test_add_item_in_cart_for_supplier_user()
    {
        $payload = [
            'productId' => 1,
            'quantity' => 2,
            'unitPrice' => 100.00,
        ];

        $response = $this->actingAs($this->supplierUser)->postJson('/api/cart/add', $payload);

        $response->assertStatus(403);
    }
}
