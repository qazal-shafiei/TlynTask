<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Services\Interfaces\TransactionServiceInterface;

class TransactionService implements TransactionServiceInterface
{
    protected $transactionRepo;

    public function __construct(TransactionRepositoryInterface $transactionRepo)
    {
        $this->transactionRepo = $transactionRepo;
    }

    public function createTransactionForOrder(Order $order)
    {
        return $this->transactionRepo->createTransactionForOrder($order);
    }
}
