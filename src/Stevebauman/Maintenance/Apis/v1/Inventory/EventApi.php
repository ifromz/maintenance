<?php

namespace Stevebauman\Maintenance\Apis\v1\Inventory;

use Stevebauman\Maintenance\Services\Inventory\InventoryService;
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

    public function __construct(InventoryService $inventory, EventService $event)
    {
        $this->inventory = $inventory;
        $this->event = $event;

        /*
         * Set the asset calendar
         */
        $this->event->eventApi->setCalendar(config('maintenance::site.calendars.inventories'));
    }

    public function show($inventory_id)
    {
        $item = $this->inventory->find($inventory_id);

        $data = array(
            'timeMin' => strToRfc3339($this->input('start')),
            'timeMax' => strToRfc3339($this->input('end')),
        );

        $inventoryEvents = $item->events->lists('api_id');

        $apiEvents = $this->event->setInput($data)->getApiEvents($inventoryEvents, $recurrences = true);

        return $this->responseJson($this->event->parseEvents($apiEvents));
    }

}