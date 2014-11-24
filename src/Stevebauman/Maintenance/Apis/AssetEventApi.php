<?php namespace Stevebauman\Maintenance\Apis;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Services\AssetEventService;
use Stevebauman\Maintenance\Apis\BaseApiController;

class AssetEventApi extends BaseApiController {

    public function __construct(AssetEventService $event){
            $this->event = $event;
    }
    
    public function index(){
        
    }
    
    public function show($asset_id){
        
        $format = 'Y-m-d H:i:s';
            
        $data = array(
            'start' => date($format, Input::get('start')),
            'end' => date($format, Input::get('end')),
        );
        
        $events = $this->event->parseEvents($this->event->with(array('assets'=>function($query) use($asset_id){
            $query->where('asset_id', $asset_id);
        }))->get(), $data);
        
        return Response::json($events);
        
        
    }
    
}