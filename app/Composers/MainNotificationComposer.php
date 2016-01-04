<?php

namespace App\Composers;

use Illuminate\View\View;
use App\Services\NotificationService;

class MainNotificationComposer
{
    /**
     * @var NotificationService
     */
    protected $notification;

    /**
     * Constructor.
     *
     * @param NotificationService $notification
     */
    public function __construct(NotificationService $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param $view
     */
    public function compose(View $view)
    {
        $notifications = $this->notification
            ->where('user_id', auth()->id())
            ->where('read', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        $view->with('notifications', $notifications);
    }
}
