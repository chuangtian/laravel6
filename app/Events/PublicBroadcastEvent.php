<?php

namespace App\Events;

use App\Models\Users;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PublicBroadcastEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $article;

    /**
     * 事件被推送的队列名称.
     *
     * @var string
     */
    public $broadcastQueue = 'myBroadcast';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Users $article)
    {
        $this->article = $article;
    }

    /**
     * 广播频道
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('publicChannel');
    }

    /**
     * 广播内容
     *
     * @return string
     */    public function broadcastWith(){
    return [
        'id' => 'xxxx',
        'article' => $this->article,
    ];
}

    /**
     * 广播的事件名称.如果未定义则默认为事件名称即 App\Events\PublicBroadcastEvent
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'publicArticle';
    }


    /**
     * 判定事件是否广播
     *
     * @return bool
     */
    public function broadcastWhen()
    {
        return $this->article->id < 100;
    }


}
