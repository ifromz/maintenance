<?php

namespace Stevebauman\Maintenance\Controllers\Asset\Event;

use Stevebauman\Maintenance\Validators\EventValidator;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Controllers\Event\BaseEventController;

class EventController extends BaseEventController {
    
    public function __construct(AssetService $eventable, EventService $event, EventValidator $eventValidator)
    {
        $this->eventable = $eventable;
        $this->eventableName = 'Asset';
        $this->eventableNameField = 'name';
        
        parent::__construct($event, $eventValidator);
    }
    
}