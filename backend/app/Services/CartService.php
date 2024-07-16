<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartService
{
    public function createCartForUser(User $user): Cart
    {
        return Cart::create(['customer_id' => $user->roleInstance->id]);
    }

    public function addItemInCartForCurrentUser(int $productId, int $quantity, float $unitPrice): CartItem
    {
        $user = Auth::user();
        $cart = $user->roleInstance->cart;

        return $this->addItemInCart($productId, $cart, $quantity, $unitPrice);
    }

    public function addItemInCart(int $productId, Cart $cart, int $quantity, float $unitPrice): CartItem
    {
        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'quantity' => $quantity,
            'item_price' => $quantity * $unitPrice,
        ]);
    }
}
