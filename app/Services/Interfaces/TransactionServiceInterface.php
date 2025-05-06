<?php

namespace App\Services\Interfaces;

use App\Models\Order;

interface TransactionServiceInterface
{
    public function createTransactionForOrder(Order $order);
}
