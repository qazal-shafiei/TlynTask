<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessOrderJob;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_order()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/orders', [
            'user_id' => $user->id,
            'type' => 'buy',
            'price' => 100.0,
            'quantity' => 1,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id', 'user_id', 'type', 'price', 'quantity', 'status', 'created_at', 'updated_at',
        ]);
    }

    /** @test */
    public function it_can_view_an_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/orders/' . $order->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $order->id,
            'user_id' => $user->id,
            'type' => $order->type,
            'price' => $order->price,
            'quantity' => $order->quantity,
        ]);
    }

    /** @test */
    public function it_can_cancel_an_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->postJson('/api/orders/' . $order->id . '/cancel');

        $response->assertStatus(200);
        $this->assertEquals(Order::STATUS_CANCELLED, $order->fresh()->status);
    }

    /** @test */
    public function it_can_process_an_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id, 'status' => Order::STATUS_PENDING]);

        // Mock the job queue
        Queue::fake();

        // Dispatch the job
        $response = $this->postJson('/api/orders/' . $order->id . '/process');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Order processing started']);

        // Assert that the job was dispatched
        Queue::assertPushed(ProcessOrderJob::class, function ($job) use ($order) {
            return $job->order->id === $order->id;
        });
    }
}
