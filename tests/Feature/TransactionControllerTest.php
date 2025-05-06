<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_transaction()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->postJson('/api/transactions', [
            'order_id' => $order->id,
            'amount' => 100.0,
            'status' => 'completed',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id', 'order_id', 'amount', 'status', 'created_at', 'updated_at',
        ]);
    }

    /** @test */
    public function it_can_view_a_transaction()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->getJson('/api/transactions/' . $transaction->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $transaction->id,
            'order_id' => $transaction->order_id,
            'amount' => $transaction->amount,
            'status' => $transaction->status,
        ]);
    }
}
