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
        
        $events = $this->event->parseEvents($this->event->getFromObject($asset));
        
        return Response::json($events);
    }
    
}