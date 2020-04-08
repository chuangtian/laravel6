<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestBroadcastingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;

    public function __construct($message)
    {
        $this->$message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('push');
    }

    # 或者可以指定返回的格式和数据
    public function broadcastWith()
    {
        return [
            'data' => $this->message
        ];
    }
}

