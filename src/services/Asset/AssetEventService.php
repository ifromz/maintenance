<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\AssetEventNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Event;
use Stevebauman\Maintenance\Services\EventService;

class AssetEventService extends EventService {
    
    public function __construct(Event $model, SentryService $sentry, AssetEventNotFoundException $notFoundException) {
        parent::__construct($model, $sentry, $notFoundException);
    }
    
    
    
}