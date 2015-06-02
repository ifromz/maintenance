<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Http\Apis\v1\AbstractEventableApi;

/**
 * Class EventApi.
 */
class EventApi extends AbstractEventableApi
{
    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param WorkOrderService $workOrder
     * @param EventService     $event
     * @param ConfigService    $config
     */
    public function __construct(WorkOrderService $workOrder, EventService $event, ConfigService $config)
    {
        parent::__construct($event);

        $this->eventable = $workOrder;

        $this->config = $config->setPrefix('maintenance');

        /*
         * Set the asset calendar
         */
        $this->event->eventApi->setCalendar($this->config->get('site.calendars.work-orders'));
    }
}
