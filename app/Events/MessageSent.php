<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Message $message)
    {
        Log::info('MessageSent event constructed', [
            'message_id' => $message->id,
            'admin_id' => $message->admin_id,
            'intern_id' => $message->intern_id
        ]);

        
    }

    public function broadcastOn()
    {
        $channelName = "private-chat.admin-{$this->message->admin_id}.intern-{$this->message->intern_id}";
        Log::info('Broadcasting on channel', ['channel' => $channelName]);
        return new PrivateChannel($channelName);
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'admin_id' => $this->message->admin_id,
            'intern_id' => $this->message->intern_id,
            'sender_type' => $this->message->sender_type,
            'message' => $this->message->message,
            'created_at' => $this->message->created_at->toIso8601String(),
            'updated_at' => $this->message->updated_at->toIso8601String(),
            'time' => $this->message->time,
        ];
    }
}