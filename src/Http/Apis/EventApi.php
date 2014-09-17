<?php namespace Stevebauman\Maintenance\Http\Apis;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;
use Stevebauman\Maintenance\Services\EventService;
use Stevebauman\Maintenance\Http\Apis\BaseApiController;

class EventApi extends BaseApiController {
	
	public function __construct(EventService $event){
		$this->event = $event;
	}
        
        public function index(){
            $format = 'Y-m-d H:i:s';
            
            $data = array(
                'start' => date($format, Input::get('start')),
                'end' => date($format, Input::get('end')),
            );
            
            $events = $this->event->parseEvents($this->event->get(), $data);
            
            return Response::json($events);
        }
        
        public function create(){
            return Response::json(
                View::make('maintenance::apis.calendar.events.create')->render()
            );
        }
        
        public function store(){
            
        }
        
        public function show($id){
            try{
                
                $event = $this->event->find($id);
                
                return Response::json(
                    View::make('maintenance::apis.calendar.events.show', array('event'=>$event))->render()
                );
                
            }catch(RecordNotFoundException $e){
                return NULL;
            }
        }
        
        public function edit($id){
            
        }
        
        public function update($id){
            try{
               
                $this->event->update($id, Input::all());
                
                return Response::json(array(
                    'message' => 'Successfully updated event',
                    'messageType' => 'success',
                ));
                
            } catch (RecordNotFoundException $ex) {
                return NULL;
            }
        }
        
        public function destroy($id){
            
        }
        
}