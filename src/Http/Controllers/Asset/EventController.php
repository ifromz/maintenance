<?php

namespace Stevebauman\Maintenance\Http\Controllers\Asset;

use Stevebauman\Maintenance\Validators\Event\EventValidator;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Http\Controllers\Event\AbstractEventableController;

class EventController extends AbstractEventableController
{
    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param AssetService   $asset
     * @param EventService   $event
     * @param ConfigService  $config
     * @param EventValidator $eventValidator
     */
    public function __construct(
        AssetService $asset,
        EventService $event,
        ConfigService $config,
        EventValidator $eventValidator
    ) {
        $this->eventable = $asset;
        $this->config = $config->setPrefix('maintenance');

        $this->eventableCalendarId = $this->config->get('site.calendars.assets');

        /*
         * Construct the abstract eventable controller
         */
        parent::__construct($event, $eventValidator);
    }
}
