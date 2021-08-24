<?php

namespace Modules\Notification\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Notification\Entities\Notification;

class BroadcastCompanyNotification implements ShouldBroadcast, ShouldQueue
{
    use SerializesModels;

    /**
     * @var Notification
     */
    public $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function broadcastAs()
    {
        return 'notifications.account.' . $this->notification->account_id;
    }

    /**
     * Get the channels the event should broadcast on.
     * @return array
     */
    public function broadcastOn()
    {
        return ['notifications'];
    }
}
