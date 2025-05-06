<?php

namespace App\Services\Interfaces;

interface OrderServiceInterface
{
    public function createOrder(array $data);
    public function getOrderById($id);
}
