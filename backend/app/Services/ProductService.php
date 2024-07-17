<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Models\Users\Supplier;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function getAllProductsWithSupplierData(): Collection
    {
        $suppliers = Supplier::with(['products', 'user'])->get();

        $result = [];
        foreach($suppliers as $supplier) {
            $currentEntry['supplierId'] = $supplier->user_id;
            $currentEntry['supplierName'] = $supplier->user->name;
            foreach($supplier->products as $product) {
                $currentEntry['products'][] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->stock_quantity,
                    'description' => $product->description,
                    'publishDate' => Carbon::parse($product->created_at)->format('Y-m-d H:i')
                ];
            }
            $result[] = $currentEntry;
        }

        return collect($result);
    }

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

    public function reduceProductStock(int $productId, int $supplierId, int $buyingQuantity): void
    {
        $supplier = Supplier::with(['products' => function (Builder $query) use ($productId) {
            $query->where('products.id', $productId);
        }])->find($supplierId);

        $currentQuantity = $supplier->products->first()->pivot->stock_quantity;
        $newQuantity = $currentQuantity-$buyingQuantity;

        if ($newQuantity < 0) {
            throw new \Exception("stock is not enough for this order", 409);
        }

        $supplier->products()->updateExistingPivot($productId, [
            'stock_quantity' => $newQuantity,
        ]);
    }
}
