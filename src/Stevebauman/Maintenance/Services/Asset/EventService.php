<?php

namespace Stevebauman\Maintenance\Services\Asset;

use Stevebauman\Maintenance\Exceptions\AssetEventNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\CalendarEvent;
use Stevebauman\Maintenance\Services\Calendar\EventService as BaseEventService;

class EventService extends BaseEventService
{

    public function __construct(CalendarEvent $model, SentryService $sentry, AssetEventNotFoundException $notFoundException)
    {
        parent::__construct($model, $sentry, $notFoundException);
    }


}