<?php

namespace App\Services;

use App\Models\Order;
use App\Events\OrderUpdated;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Services\Interfaces\OrderServiceInterface;

class OrderService implements OrderServiceInterface
{
    protected $orderRepo;
    protected $transactionRepo;

    public function __construct(OrderRepositoryInterface $orderRepo, TransactionRepositoryInterface $transactionRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->transactionRepo = $transactionRepo;
    }

    public function createOrder(array $data)
    {
        $order = $this->orderRepo->create($data);
        $this->transactionRepo->createTransactionForOrder($order);

        event(new OrderUpdated($order));

        return $order;
    }

    public function getOrderById($id)
    {
        return $this->orderRepo->findById($id);
    }

    public function matchOrders()
    {
        $buyOrders = $this->orderRepo->getBuyOrders();
        $sellOrders = $this->orderRepo->getSellOrders();

        foreach ($buyOrders as $buyOrder) {
            foreach ($sellOrders as $sellOrder) {
                if ($buyOrder->price >= $sellOrder->price) {
                    $this->completeTransaction($buyOrder, $sellOrder);
                    break;
                }
            }
        }
    }

    protected function completeTransaction($buyOrder, $sellOrder)
    {
        $this->orderRepo->updateStatus($buyOrder, Order::STATUS_COMPLETED);
        $this->orderRepo->updateStatus($sellOrder, Order::STATUS_COMPLETED);

        $this->transactionRepo->createTransactionForOrder($buyOrder);
    }

    public function cancelOrder(Order $order)
    {
        $this->orderRepo->cancel($order);
    }
}
