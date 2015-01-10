<?php

namespace Stevebauman\Maintenance\Apis\v1\Inventory;

use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Apis\v1\AbstractEventableApi;

class EventApi extends AbstractEventableApi {


    public function __construct(InventoryService $inventory, EventService $event)
    {
        parent::__construct($event);

        $this->eventable = $inventory;

        /*
         * Set the asset calendar
         */
        $this->event->eventApi->setCalendar(config('maintenance::site.calendars.inventories'));
    }

}