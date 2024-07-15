<?php

namespace App\Services;

use App\Models\Users\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function getAllProductsForSupplier(): Collection
    {
        $user = Auth::user();
//        if($user->roleInstance->getRole() !== 'supplier')
//        {
//            throw new \Exception('only suppliers can view their products', 401);
//        }

        $role = Supplier::where('user_id', $user->id)->with('products')->first();
        return $role->products;
    }
}
