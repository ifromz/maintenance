<?php

namespace Stevebauman\Maintenance\Controllers\Inventory;

use Stevebauman\Maintenance\Validators\Event\EventValidator;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Controllers\Event\AbstractEventableController;

class EventController extends AbstractEventableController {

    public function __construct(InventoryService $inventory, EventService $event, EventValidator $eventValidator)
    {
        $this->eventable = $inventory;

        $this->eventableCalendarId = config('maintenance::site.calendars.inventories');

        parent::__construct($event, $eventValidator);
    }

}