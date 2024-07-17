<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartService
{
    public function createCartForUser(User $user): Cart
    {
        assert($user->role === 'customer');

        return Cart::create(['customer_id' => $user->customer->id]);
    }

    public function addItemInCartForUser(User $user, int $productId, int $quantity, float $unitPrice): CartItem
    {
        assert($user->role === 'customer');

        $user->load('customer.cart');
        $cart = $user->customer->cart;

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

    public function getAllCartItemsForUser(User $user): Collection
    {
        assert($user->role === 'customer');
        $user->loadMissing('customer.cart.items.product');
        $items = $user->customer->cart->items;

        return $this->formatCartItemsForIndexRequest($items);
    }

    private function formatCartItemsForIndexRequest(Collection $items): Collection
    {
        $result = [];
        foreach($items as $item) {
            $product = $item->product;

            $result[] = [
                'name' =>$product->name,
                'quantity' => $item->quantity,
                'totalPrice' => $item->item_price,
            ];
        }

        return collect($result);
    }
}
