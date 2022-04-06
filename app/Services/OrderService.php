<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Arr;

class OrderService
{
    public function queryOrder(int $order): Order
    {
        return Order::with(['restaurant', 'customer'])->findOrFail($order);
    }

    public function storeOrder(array $data): Order
    {
        $order = new Order();
        $order->reference = Arr::get($data, 'reference');
        $order->description = Arr::get($data, 'description');
        $order->amount = Arr::get($data, 'amount');
        $order->customer_id = Arr::get($data, 'customer_id');
        $order->restaurant_id = Arr::get($data, 'restaurant_id');
        $order->save();

        return $order;
    }
}
