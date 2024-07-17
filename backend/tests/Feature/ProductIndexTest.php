<?php
namespace Tests\Feature;

use App\Models\Users\Customer;
use App\Models\Users\Supplier;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $supplierUser;
    protected $customerUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->supplierUser = Supplier::factory()->createSupplierWithRole();
        $this->customerUser = Customer::factory()->createCustomerWithRole();

        for($i = 0; $i < 10; $i++){
            $data = [
                'name' => $this->faker->company,
                'price' => $this->faker->randomFloat(2, 1, 1000),
                'description' => $this->faker->text(200),
                'quantity' => $this->faker->numberBetween(1, 100)
            ];

            (new ProductService())->createProductForSupplier($data, $this->supplierUser);
        }
    }

    public function test_create_product_with_valid_data()
    {
        $response = $this->actingAs($this->supplierUser)->getJson('/api/product/index');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'price',
                'description',
                'created_at',
                'updated_at',
                'pivot' => [
                    'supplier_id',
                    'product_id',
                    'stock_quantity'
                ],
            ],
        ]);
    }
}
