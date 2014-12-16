<?php namespace Stevebauman\Maintenance\Apis;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Apis\BaseApiController;

/**
 * API for FullCalendar interactions
 */
class EventApi extends BaseApiController {
	
	public function __construct(EventService $event)
        {
            $this->event = $event;
	}
        
        public function index()
        {

            $timeMin = new \DateTime();
            $timeMin->setTimestamp(Input::get('start'));
            
            $timeMax = new \DateTime();
            $timeMax->setTimestamp(Input::get('end'));
            
            $data = array(
                'timeMin' => $timeMin->format(\DateTime::RFC3339),
                'timeMax' => $timeMax->format(\DateTime::RFC3339),
            );
            
            $events = $this->event->parseEvents($this->event->setInput($data)->getApiEvents());
            
            return Response::json($events);
        }
        
        public function create()
        {
            return Response::json(
                View::make('maintenance::apis.calendar.events.create')->render()
            );
        }
        
        public function store(){
            
        }
        
        public function show($id)
        {
            try {
                $event = $this->event->find($id);
                
                return Response::json(
                    View::make('maintenance::apis.calendar.events.show', array('event'=>$event))->render()
                );
                
            }catch(RecordNotFoundException $e){
                return NULL;
            }
        }
        
        public function edit($id)
        {
            
        }
        
        public function update($id)
        {
            try{
               
                $this->event->setInput($this->inputAll())->updateDates($id);
                
                return Response::json(array(
                    'message' => 'Successfully updated event',
                    'messageType' => 'success',
                ));
                
            } catch (RecordNotFoundException $ex) {
                return NULL;
            }
        }
        
        public function destroy($id)
        {
            
        }
        
}