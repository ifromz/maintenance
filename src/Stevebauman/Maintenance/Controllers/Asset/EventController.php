<?php

namespace Stevebauman\Maintenance\Controllers\Asset;

use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Controllers\BaseController;

class EventController extends BaseController {
    
    public function __construct(EventService $event)
    {
        $this->event = $event;
    }
    
    public function index($asset_id)
    {
        
    }
    
    public function create($asset_id)
    {
        
    }
    
    public function store($asset_id)
    {
        
    }
    
    public function show($asset_id, $event_id)
    {
        
    }
    
    public function edit($asset_id, $event_id)
    {
        
    }
    
    public function update($asset_id, $event_id)
    {
        
    }
    
    public function destroy($asset_id, $event_id)
    {
        
    }
}