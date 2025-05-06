<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Jobs\ProcessOrderJob;
use App\Services\Interfaces\OrderServiceInterface;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(OrderRequest $request)
    {
        $order = $this->orderService->createOrder($request->validated());
        return new OrderResource($order);
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderById($id);
        return new OrderResource($order);
    }

    public function cancel($id)
    {
        $order = $this->orderService->getOrderById($id);
        $this->orderService->cancelOrder($order);
        return response()->json(['message' => 'Order cancelled successfully'], 200);
    }

    public function processOrder($id)
    {
        $order = $this->orderService->getOrderById($id);
        ProcessOrderJob::dispatch($order);
        return response()->json(['message' => 'Order processing started'], 200);
    }
}
