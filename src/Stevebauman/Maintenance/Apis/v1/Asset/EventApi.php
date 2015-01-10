<?php

namespace Stevebauman\Maintenance\Apis\v1\Asset;

use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Apis\v1\AbstractEventableApi;

class EventApi extends AbstractEventableApi {


    public function __construct(AssetService $asset, EventService $event)
    {
        parent::__construct($event);

        $this->eventable = $asset;

        /*
         * Set the asset calendar
         */
        $this->event->eventApi->setCalendar(config('maintenance::site.calendars.assets'));
    }

}