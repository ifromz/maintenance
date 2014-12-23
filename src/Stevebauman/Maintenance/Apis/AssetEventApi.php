<?php namespace Stevebauman\Maintenance\Apis;

use Illuminate\Support\Facades\Response;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Apis\BaseApiController;

class AssetEventApi extends BaseApiController {

    public function __construct(AssetService $asset, EventService $event) 
    {
        $this->asset = $asset;
        $this->event = $event;
    }
    
    public function index()
    {
        
    }
    
    public function show($asset_id)
    {
        $asset = $this->asset->find($asset_id);
        
        $apiEvents = array();
        
        foreach($asset->events as $event) {
            
            /*
             * TODO - Get recurrances
             */
            $apiEvents[] = $this->event->findByApiId($event->api_id);
            
        }
        
        $events = $this->event->parseEvents($apiEvents);
        
        return Response::json($events);
    }
    
}