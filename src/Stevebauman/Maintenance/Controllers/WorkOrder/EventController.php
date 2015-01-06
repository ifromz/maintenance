<?php

namespace Stevebauman\Maintenance\Controllers\Inventory;

use Stevebauman\Maintenance\Validators\Event\EventValidator;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Controllers\Event\AbstractEventableController;

class EventController extends AbstractEventableController {

    public function __construct(WorkOrderService $workOrder, EventService $event, EventValidator $eventValidator)
    {
        $this->eventable = $workOrder;

        $this->eventableCalendarId = config('maintenance::site.calendars.work-orders');

        parent::__construct($event, $eventValidator);
    }

}