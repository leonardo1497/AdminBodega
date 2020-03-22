<?php

namespace App\Events;

use App\Fruit;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FruitTable implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $fruit;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fruit = Fruit::all();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('fruit');
    }

        /**
     * Set the event name
     *
     * @return string
     */
    public function broadcastAs() {
        return 'examplee';
    }
}
