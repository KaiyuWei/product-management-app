<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_supplier_can_view_their_products()
    {
        $user = User::create([
            'role' => 'supplier'
        ]);

        $products = Product::factory()->count(3)->create([
            'supplier_id' => $supplier->id,
        ]);

        Auth::login($user);

        $response = $this->getAllProductsForSupplier();

        $this->assertCount(3, $response);
        $this->assertEquals($products->pluck('id')->toArray(), $response->pluck('id')->toArray());
    }
}
