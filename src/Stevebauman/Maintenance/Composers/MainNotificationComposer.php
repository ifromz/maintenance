<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\NotificationService;

class MainNotificationComposer
{

    public function __construct(SentryService $sentry, NotificationService $notification)
    {
        $this->sentry = $sentry;
        $this->notification = $notification;
    }

    public function compose($view)
    {
        $notifications = $this->notification
            ->where('user_id', $this->sentry->getCurrentUserId())
            ->where('read', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        $view->with('notifications', $notifications);
    }

}