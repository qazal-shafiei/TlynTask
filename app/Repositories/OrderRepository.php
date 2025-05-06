<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data)
    {
        return Order::create($data);
    }

    public function findById($id)
    {
        return Order::findOrFail($id);
    }

    public function getBuyOrders()
    {
        return Order::where('type', 'buy')
            ->where('status', Order::STATUS_PENDING)
            ->orderByDesc('price')
            ->get();
    }

    public function getSellOrders()
    {
        return Order::where('type', 'sell')
            ->where('status', Order::STATUS_PENDING)
            ->orderBy('price')
            ->get();
    }

    public function cancel(Order $order)
    {
        $order->status = Order::STATUS_CANCELLED;
        $order->save();
    }

    public function updateStatus(Order $order, $status)
    {
        $order->status = $status;
        $order->save();
    }
}
