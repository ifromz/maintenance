<?php

namespace Stevebauman\Maintenance\Http\Controllers\Inventory;

use Stevebauman\Maintenance\Validators\Event\EventValidator;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Http\Controllers\Event\AbstractEventableController;

class EventController extends AbstractEventableController
{
    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param InventoryService $inventory
     * @param EventService     $event
     * @param ConfigService    $config
     * @param EventValidator   $eventValidator
     */
    public function __construct(
        InventoryService $inventory,
        EventService $event,
        ConfigService $config,
        EventValidator $eventValidator
    ) {
        $this->eventable = $inventory;

        $this->config = $config->setPrefix('maintenance');

        $this->eventableCalendarId = $this->config->get('site.calendars.inventories');

        parent::__construct($event, $eventValidator);
    }
}
