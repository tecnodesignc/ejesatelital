<?php

namespace Modules\Notification\Services;

interface Notification
{
    /**
     * Push a notification on the dashboard
     * @param string $title
     * @param string $message
     * @param string $icon
     * @param string|null $link
     */
    public function push(string $title, string $message, string $icon, string $link = null);

    /**
     * Set a user id to set the notification to a specific user
     * @param int $user_id
     * @return $this
     */
    public function to(int $user_id);

    /**
     * Set a user id to set the notification to
     * @param int $account_id
     * @return $this
     */

    public function account(int $account_id);
}
