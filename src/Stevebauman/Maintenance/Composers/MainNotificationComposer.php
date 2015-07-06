<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\NotificationService;

class MainNotificationComposer
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var NotificationService
     */
    protected $notification;

    /**
     * @param SentryService       $sentry
     * @param NotificationService $notification
     */
    public function __construct(SentryService $sentry, NotificationService $notification)
    {
        $this->sentry = $sentry;
        $this->notification = $notification;
    }

    /**
     * @param $view
     */
    public function compose(View $view)
    {
        $notifications = $this->notification
            ->where('user_id', $this->sentry->getCurrentUserId())
            ->where('read', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        $view->with('notifications', $notifications);
    }
}
