<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PushMsgEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $msg;

    /**
     *  定义 msg 变量，保存弹幕消息
     */
    public function __construct( $msg )
    {
        // 简单的消息列表
        $this->msg = $msg;

    }

    /**
     *  弹幕所有人都可以收到，所以返回公共频道就 OK 的
     */
    public function broadcastOn()
    {
        return new Channel('push');
    }

    public function broadcastWith(){
        return $this->msg;
    }

    /**
     *  重命名一下广播名称，一般默认为类名
     */
    public function broadcastAs()
    {
        return 'push.msg';
    }

    public function broadcastWhen()
    {
        return $this->msg['id'] < 100;
    }
}
