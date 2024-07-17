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
        $order = Order::create(['customer_id' => $user->customer->id, 'price' =>  $price]);
        $this->addProductFromStockToOrder($order, $data);
        DB::commit();

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
            $supplierOrigin = User::with('supplier')->find($item['supplierId']);
            $buyingQuantity = $item['quantity'];

            DB::beginTransaction();
            $this->removeQuantityFromProductStock($productId, $supplierOrigin->supplier->id, $buyingQuantity);
            $orderItem = $this->addProductToOrder($order->id, $supplierOrigin->supplier->id, $productId, $item['quantity'], $item['totalPrice']);
            DB::commit();

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
