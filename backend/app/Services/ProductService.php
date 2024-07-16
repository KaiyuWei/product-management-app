<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Models\Users\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function getAllProductsForSupplier(User $user): Collection
    {
        $role = $user->roleInstance()->with('products')->first();
        return $role->products;
    }

    public function createProductForSupplier(array $data, User $supplierUser): Product
    {
        $product = null;
        DB::transaction(function () use($data, $supplierUser, &$product) {
            $product = new Product($data);
            $supplierUser->roleInstance->products()->save($product, [
                'price' => $product->price,
                'stock_quantity' => $data['quantity'],
            ]);
        });

        return $product;
    }
}
