<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\AssetEventNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\CalendarEvent;
use Stevebauman\Maintenance\Services\CalendarEventService;

class AssetEventService extends CalendarEventService {
    
    public function __construct(CalendarEvent $model, SentryService $sentry, AssetEventNotFoundException $notFoundException) {
        parent::__construct($model, $sentry, $notFoundException);
    }
    
    
    
}