<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class FormUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $formId;
    public $indicatorData;
    public $userName;

    /**
     * Create a new event instance.
     */
    public function __construct($formId, $indicatorData, $userName)
    {
        $this->formId = $formId;    // Simpan formId
        $this->indicatorData = $indicatorData;    // Simpan indicatorData
        $this->userName = $userName;    // Simpan userName
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('forms.' . $this->formId),
        ];
    }
}