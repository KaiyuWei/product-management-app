<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Users\Customer;
use App\Models\Users\Supplier;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $customerUser;

    protected $supplierUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerUser = Customer::factory()->createCustomerWithRoleAndCart();
        $this->supplierUser = Supplier::factory()->createSupplierWithRole();

        for($i = 0; $i < 10; $i++){
            $data = [
                'name' => $this->faker->company,
                'price' => $this->faker->randomFloat(2, 1, 1000),
                'description' => $this->faker->text(200),
                'quantity' => 500
            ];

            (new ProductService())->createProductForSupplier($data, $this->supplierUser);
        }
    }

    public function test_create_order_success()
    {
        $data = [
            [
                'productId' => 1,
                'quantity' => 400,
                'totalPrice' => 200,
            ],
            [
                'productId' => 2,
                'quantity' => 300,
                'totalPrice' => 100,
            ],
        ];

        $response = $this->actingAs($this->customerUser)->postJson('/api/order/buy', $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['orderId']);

        $order = Order::first();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'customer_id' => $this->customerUser->id,
            'price' => 300,
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => 1,
            'quantity' => 2,
            'item_price' => 200,
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => 2,
            'quantity' => 1,
            'item_price' => 100,
        ]);

        $this->assertDatabaseHas('product_supplier', [
            'product_id' => 1,
            'supplier_id' => $this->supplierUser->supplier->id,
            'stock_quantity' => 100
        ]);

        $this->assertDatabaseHas('product_supplier', [
            'product_id' => 2,
            'supplier_id' => $this->supplierUser->supplier->id,
            'stock_quantity' => 200
        ]);
    }

    public function test_create_order_validation_error()
    {
        $data = [
            [
                'productId' => null,  // Invalid productId
                'quantity' => 2,
                'totalPrice' => 200,
            ],
            [
                'productId' => 2,
                'quantity' => -1,  // Invalid quantity
                'totalPrice' => 100,
            ],
        ];

        $response = $this->actingAs($this->customerUser)->postJson('/api/order/buy', $data);

        $response->assertStatus(422)->assertJsonValidationErrors(['0.productId', '1.quantity']);
    }

    public function test_create_order_for_supplier_user_fails()
    {
        $data = [
            [
                'productId' => 1,
                'quantity' => 2,
                'totalPrice' => 200,
            ],
            [
                'productId' => 2,
                'quantity' => 1,
                'totalPrice' => 100,
            ],
        ];

        $response = $this->actingAs($this->supplierUser)->postJson('/api/order/buy', $data);
        $response->assertStatus(403);
    }
}
