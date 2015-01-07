<?php

namespace Stevebauman\Maintenance\Controllers\Asset;

use Stevebauman\Maintenance\Validators\Event\EventValidator;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Controllers\Event\AbstractEventableController;

class EventController extends AbstractEventableController {

    public function __construct(AssetService $asset, EventService $event, EventValidator $eventValidator)
    {
        $this->eventable = $asset;

        $this->eventableCalendarId = config('maintenance::site.calendars.assets');

        /*
         * Construct the abstract eventable controller
         */
        parent::__construct($event, $eventValidator);
    }

}