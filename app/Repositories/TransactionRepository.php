<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\Order;
use App\Repositories\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function createTransactionForOrder(Order $order)
    {
        return Transaction::create([
            'order_id' => $order->id,
            'amount' => $this->calculateFee($order),
            'status' => 'completed',
        ]);
    }

    private function calculateFee(Order $order)
    {
        return $order->price * 0.02;
    }

    public function findById($id)
    {
        return Transaction::findOrFail($id);
    }
}
