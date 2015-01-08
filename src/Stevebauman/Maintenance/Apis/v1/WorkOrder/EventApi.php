<?php

namespace Stevebauman\Maintenance\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Services\Event\EventService;
use  Stevebauman\Maintenance\Apis\BaseApiController;

class EventApi extends BaseApiController {

    /*
     * Holds Inventory Service
     */
    private $inventory;

    /*
     * Holds Event Service
     */
    private $event;

    public function __construct(WorkOrderService $workOrder, EventService $event)
    {
        $this->workOrder = $workOrder;
        $this->event = $event;

        /*
         * Set the asset calendar
         */
        $this->event->eventApi->setCalendar(config('maintenance::site.calendars.work-orders'));
    }

    public function show($inventory_id)
    {
        $workOrder = $this->workOrder->find($inventory_id);

        $timeMin = new \DateTime();
        $timeMin->setTimestamp(strtotime($this->input('start')));

        $timeMax = new \DateTime();
        $timeMax->setTimestamp(strtotime($this->input('end')));

        $data = array(
            'timeMin' => $timeMin->format(\DateTime::RFC3339),
            'timeMax' => $timeMax->format(\DateTime::RFC3339),
        );

        $workOrderEvents = $workOrder->events->lists('api_id');

        $apiEvents = $this->event->setInput($data)->getApiEvents($workOrderEvents, $recurrences = true);

        return $this->responseJson($this->event->parseEvents($apiEvents));
    }

}