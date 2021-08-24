<?php

namespace Modules\Notification\Services;

use Modules\Notification\Events\BroadcastAllNotification;
use Modules\Notification\Events\BroadcastCompanyNotification;
use Modules\Notification\Events\BroadcastNotification;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\User\Contracts\Authentication;

final class EncoreNotification implements Notification
{
    /**
     * @var NotificationRepository
     */
    private $notification;
    /**
     * @var Authentication
     */
    private $auth;
    /**
     * @var int
     */
    private int $user_id;

    /**
     * @var int
     */
    private int $account_id;


    public function __construct(NotificationRepository $notification, Authentication $auth)
    {
        $this->notification = $notification;
        $this->auth = $auth;
    }

    /**
     * Push a notification on the dashboard
     * @param string $title
     * @param string $message
     * @param string $icon
     * @param string|null $link
     */
    public function push(string $title, string $message, $icon, $link = null)
    {
        $notification = $this->notification->create([
            'user_id' => $this->user_id??null,
            'account_id' => $this->account_id ?? null,
            'icon_class' => $icon,
            'link' => $link,
            'title' => $title,
            'message' => $message,
        ]);

        if (true === config('encore.notification.config.real-time', false)) {
            $this->triggerEventFor($notification);
        }
    }

    /**
     * Trigger the broadcast event for the given notification
     * @param \Modules\Notification\Entities\Notification $notification
     */
    private function triggerEventFor(\Modules\Notification\Entities\Notification $notification)
    {
        if (isset($this->account_id))
            event(new BroadcastCompanyNotification($notification));
        elseif(isset($this->user_id))
            event(new BroadcastNotification($notification));
        else
            event(new BroadcastAllNotification($notification));

    }

    /**
     * Set a user id to set the notification to
     * @param int $user_id
     * @return $this
     */
    public function to(int $user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }
    /**
     * Set a user id to set the notification to
     * @param int $account_id
     * @return $this
     */
    public function account(int $account_id)
    {
        $this->account_id = $account_id;

        return $this;
    }
}
