<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($message = null)
    {
        \Log::info('イベントのコンストラクタ が呼び出されました');
        $this->message = $message;
        // $messages = new Message();
        // $messages->message = $message;
        // $messages->save();
    }

    public function broadcastOn()
    {
        \Log::info('broadcastOn が呼び出されました');
        return [new Channel('chat-channel')];
    }

    public function broadcastAs()
    {
        return 'message.sent'; // イベント名
    }

    // /**
    //  * Get the channels the event should broadcast on.
    //  *
    //  * @return array<int, \Illuminate\Broadcasting\Channel>
    //  */
    // public function broadcastOn(): array
    // {
    //     return [
    //         new PrivateChannel('channel-chat'),
    //     ];
    // }
}
