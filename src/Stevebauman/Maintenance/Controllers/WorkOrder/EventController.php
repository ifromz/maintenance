<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Validators\Event\EventValidator;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Controllers\Event\AbstractEventableController;

/**
 * Class EventController
 * @package Stevebauman\Maintenance\Controllers\WorkOrder
 */
class EventController extends AbstractEventableController
{
    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param WorkOrderService $workOrder
     * @param EventService $event
     * @param ConfigService $config
     * @param EventValidator $eventValidator
     */
    public function __construct(
        WorkOrderService $workOrder,
        EventService $event,
        ConfigService $config,
        EventValidator $eventValidator
    )
    {
        $this->eventable = $workOrder;

        $this->config = $config->setPrefix('maintenance');

        $this->eventableCalendarId = $this->config->get('site.calendars.work-orders');

        parent::__construct($event, $eventValidator);
    }

}