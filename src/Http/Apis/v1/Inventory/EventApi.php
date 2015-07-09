<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Inventory;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Http\Apis\v1\AbstractEventableApi;

class EventApi extends AbstractEventableApi
{
    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param InventoryService $inventory
     * @param EventService     $event
     * @param ConfigService    $config
     */
    public function __construct(InventoryService $inventory, EventService $event, ConfigService $config)
    {
        parent::__construct($event);

        $this->eventable = $inventory;

        $this->config = $config->setPrefix('maintenance');

        /*
         * Set the asset calendar
         */
        $this->event->eventApi->setCalendar($this->config->get('site.calendars.inventories'));
    }
}
