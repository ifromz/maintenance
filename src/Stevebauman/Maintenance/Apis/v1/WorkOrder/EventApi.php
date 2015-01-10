<?php

namespace Stevebauman\Maintenance\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Apis\v1\AbstractEventableApi;

class EventApi extends AbstractEventableApi {


    public function __construct(WorkOrderService $workOrder, EventService $event)
    {
        parent::__construct($event);

        $this->eventable = $workOrder;

        /*
         * Set the asset calendar
         */
        $this->event->eventApi->setCalendar(config('maintenance::site.calendars.work-orders'));
    }

}