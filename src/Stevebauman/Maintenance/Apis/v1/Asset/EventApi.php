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
        
        $timeMin = new \DateTime();
        $timeMin->setTimestamp(strtotime($this->input('start')));

        $timeMax = new \DateTime();
        $timeMax->setTimestamp(strtotime($this->input('end')));

        $data = array(
            'timeMin' => $timeMin->format(\DateTime::RFC3339),
            'timeMax' => $timeMax->format(\DateTime::RFC3339),
        );
        
        $apiEvents = $this->event->setInput($data)->getApiEvents($asset->events->lists('api_id'), $recurrences = true);

        return $this->responseJson($this->event->parseEvents($apiEvents));
    }
    
}