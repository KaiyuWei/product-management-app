<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function createOrderForUser(User $user, array $data)
    {
        assert($user->role === 'customer');

        $data = collect($data);
        $price = $this->calcTotalOrderPriceFromData($data);

        DB::beginTransaction();
        try {
            $order = Order::create(['customer_id' => $user->customer->id, 'price' =>  $price]);
            $this->addProductFromStockToOrder($order, $data);
            (new CartService())->removeCartItemsForCustomer($user->customer);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $order;
    }

    private function calcTotalOrderPriceFromData(Collection $data): float
    {
        return $data->sum('totalPrice');
    }

    private function addProductFromStockToOrder(Order $order, Collection $data): Collection
    {
        return $data->map(function($item) use ($order) {
            $productId = $item['productId'];
            $buyingQuantity = $item['quantity'];

            DB::beginTransaction();
            try {
                $this->removeQuantityFromProductStock($productId, $item['supplierId'], $buyingQuantity);
                $orderItem = $this->addProductToOrder($order->id, $item['supplierId'], $productId, $item['quantity'], $item['totalPrice']);
                DB::commit();
            } catch(\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            return $orderItem;
        });
    }

    private function removeQuantityFromProductStock(int $productId, int $supplierId, int $buyingQuantity)
    {
        (new ProductService())->reduceProductStock($productId, $supplierId, $buyingQuantity);
    }

    private function addProductToOrder(int $orderId, int $supplierId, int $productId, int $quantity, float $price)
    {
        return OrderItem::create([
            'order_id' => $orderId,
            'supplier_id' => $supplierId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'item_price' => $price
        ]);
    }
}
