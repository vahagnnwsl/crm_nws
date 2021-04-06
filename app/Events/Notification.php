<?php

namespace App\Events;

use App\Models\LinkedinMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Notification implements ShouldBroadcast
{
    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public string $broadcastQueue = 'notification';

    /**
     * @var LinkedinMessage
     */
    private array $notification;

    /**
     * @var string
     */
    private string $channel_name;

    /**
     * Notification constructor.
     * @param array $notification
     * @param string $channel_name
     */
    public function __construct(array $notification,string $channel_name)
    {
        $this->notification = $notification;
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
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return $this->notification;
    }

    /**
     * Broadcast event name
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'new-notification';
    }
}
