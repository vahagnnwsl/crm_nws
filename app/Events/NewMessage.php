<?php

namespace App\Events;

use App\Http\Resources\LinkedinMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcast
{
    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public string $broadcastQueue = 'conversation-messages';

    /**
     * @var LinkedinMessage
     */
    private array $message;

    /**
     * @var string
     */
    private string $channel_name;

    /**
     * NewMessage constructor.
     * @param array $message
     * @param string $channel_name
     */
    public function __construct(array $message,string $channel_name)
    {
        $this->message = $message;
        $this->channel_name = $channel_name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channel.'.$this->channel_name );
    }

    /**
     * @return LinkedinMessage|array
     */
    public function broadcastWith()
    {
        return $this->message;
    }

    /**
     * Broadcast event name
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'newMessage';
    }
}
