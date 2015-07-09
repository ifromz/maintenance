<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Asset;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Http\Apis\v1\AbstractEventableApi;

class EventApi extends AbstractEventableApi
{
    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param AssetService  $asset
     * @param EventService  $event
     * @param ConfigService $config
     */
    public function __construct(AssetService $asset, EventService $event, ConfigService $config)
    {
        parent::__construct($event);

        $this->eventable = $asset;

        $this->config = $config->setPrefix('maintenance');

        /*
         * Set the asset calendar
         */
        $this->event->eventApi->setCalendar($this->config->get('site.calendars.assets'));
    }
}
