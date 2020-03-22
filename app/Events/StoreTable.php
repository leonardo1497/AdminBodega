<?php

namespace App\Events;

use App\Store;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class StoreTable implements ShouldBroadcast{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $store;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->store = Store::all();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('store');
    }

        /**
     * Set the event name
     *
     * @return string
     */
    public function broadcastAs() {
        return 'data';
    }
}
