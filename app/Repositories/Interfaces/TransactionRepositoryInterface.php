<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface TransactionRepositoryInterface
{
    public function create(array $data);
    public function findById($id);
    public function createTransactionForOrder(Order $order);
}
