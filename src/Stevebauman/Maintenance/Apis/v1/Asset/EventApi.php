<?php

namespace Stevebauman\Maintenance\Apis\v1\Asset;

use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Apis\BaseApiController;

class EventApi extends BaseApiController {

    public function __construct(AssetService $asset, EventService $event) 
    {
        $this->asset = $asset;
        $this->event = $event;

        /*
         * Set the asset calendar
         */
        $this->event->eventApi->setCalendar(config('maintenance::site.calendars.assets'));
    }
    
    public function index()
    {
        
    }
    
    public function show($asset_id)
    {
        $asset = $this->asset->find($asset_id);

        $data = array(
            'timeMin' => strToRfc3339($this->input('start')),
            'timeMax' => strToRfc3339($this->input('end')),
        );
        
        $apiEvents = $this->event->setInput($data)->getApiEvents($asset->events->lists('api_id'), $recurrences = true);

        return $this->responseJson($this->event->parseEvents($apiEvents));
    }
    
}