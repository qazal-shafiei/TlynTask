<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Transaction;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessOrderJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $order;
    protected $orderRepo;
    protected $transactionRepo;

    public function __construct(Order $order, OrderRepositoryInterface $orderRepo, TransactionRepositoryInterface $transactionRepo)
    {
        $this->order = $order;
        $this->orderRepo = $orderRepo;
        $this->transactionRepo = $transactionRepo;
    }

    public function handle()
    {
        try {
            $this->order->type === 'buy'
            ? $this->processBuyOrder()
            : $this->processSellOrder();
        } catch (\Exception $e) {
            Log::error('Error processing order: ' . $e->getMessage());
        }
    }

    protected function processBuyOrder()
    {
        $this->order->status = Order::STATUS_COMPLETED;
        $this->order->save();

        $this->transactionRepo->createTransactionForOrder($this->order);
    }

    protected function processSellOrder()
    {
        $this->order->status = Order::STATUS_COMPLETED;
        $this->order->save();

        $this->transactionRepo->createTransactionForOrder($this->order);
    }
}
