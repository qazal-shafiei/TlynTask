<?php

namespace App\Listeners;

use App\Events\OrderUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OrderUpdatedListener implements ShouldQueue
{
    public function handle(OrderUpdated $event)
    {
        $order = $event->order;

        Log::info('Order status updated', ['order_id' => $order->id, 'new_status' => $order->status]);
    }
}
