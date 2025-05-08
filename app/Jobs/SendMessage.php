<?php

namespace App\Jobs;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Message $message) {}

    public function handle(): void
    {
        broadcast(new MessageSent($this->message));
    }
}
