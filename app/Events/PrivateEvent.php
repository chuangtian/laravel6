<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Users as User;


class PrivateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $mes;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,$mes)
    {
//        $this->user = $user;
        $this->user = $user;
        $this->mes = $mes;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //dd($this->user->id);
        return new PrivateChannel('user.'.$this->user->id);

    }

    public function broadcastWith(){
        return $this->mes;
    }


}
