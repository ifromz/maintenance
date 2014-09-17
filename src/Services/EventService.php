<?php namespace Stevebauman\Maintenance\Services;

use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Models\Event;
use Stevebauman\Maintenance\Services\SentryService;

class EventService extends AbstractModelService {
	

	public function __construct(Event $event, SentryService $sentry){
		$this->model = $event;
		$this->sentry = $sentry;
        }
        
        public function update($id, $data){
            $record = $this->model->find($id);
            
            $insert = array(
                'start' => $data['start'],
                'end' => ($data['allDay'] ? $data['start'] : $data['end']),
            );
            
            if($record->update($insert)){
                    return $record;
            } return false;
        }
        
        public function parseEvents($events, $data){

            foreach($events as $event){
                
                if($event->isRecurring()){
                    
                    $inputStart = $data['start'];
                    $inputEnd = $data['end'];
                    
                    /*
                     * Check if the recurring ends by looking at the recur_count variable. 
                     * If it does, set the rule count for Recurr.
                     * 
                     * If the reucrring does not end, set the limit accordingly to 
                     * the recur_frequency so recurring events are limited and queries are faster.
                     */
                    if($event->recurringEnds()){
                        
                       $ruleStr = sprintf('FREQ=%s;COUNT=%s;', $event->recur_frequency, $event->recur_count);
                       $constraint = NULL;
                       $limit = NULL;
                       
                    } else{
                        $ruleStr = sprintf('FREQ=%s;', $event->recur_frequency);
                        $constraint = new \Recurr\Transformer\Constraint\BetweenConstraint(new \DateTime($inputStart), new \DateTime($inputEnd));
                       
                    }
                    
                    /*
                     * Check Filters on events. Ex. If the scheduled event avoids weekends or certain days/holidays.
                     * Add each filter onto rule if set.
                     */
                    if(isset($event->recur_filter_days)){
                        $ruleStr .= sprintf('BYDAY=%s;',$event->recur_filter_days);
                    }
                    
                    if(isset($event->recur_filter_months)){
                        $ruleStr .= sprintf('BYMONTH=%s;',$event->recur_filter_months);
                    }
                    
                    if(isset($event->recur_filter_years)){
                        $ruleStr .= sprintf('BYYEAR=%s;',$event->recur_filter_years);
                    }
                    
                    $timezone    = Config::get('app.timezone'); // Set default timezone
                    $startDate   = new \DateTime($event->recur_start, new \DateTimeZone($timezone));
                    $endDate     = new \DateTime($event->recur_end, new \DateTimeZone($timezone));
                    $rule        = new \Recurr\Rule($ruleStr, $startDate, $endDate, $timezone);
                    $transformer = new \Recurr\Transformer\ArrayTransformer();
                    $rule2        = new \Recurr\Rule($ruleStr, $startDate, $endDate, $timezone);
                    
                    $recurrances = $transformer->transform($rule, $event->recur_limit, $constraint);
                    
                    foreach($recurrances as $recurrance){
                        
                        $events[] = array(
                            'id' => $event->id,
                            'title' => $event->title,
                            'description' => $event->description,
                            'start' => $recurrance->getStart()->format('Y-m-d H:i:s'),
                            'end' => $recurrance->getEnd()->format('Y-m-d H:i:s'),
                            'allDay' => $event->allDay,
                            'color' => $event->color,
                            'backgroundColor' => $event->backgroundColor,
                        );
                        
                    }
                    
                }
            }
            
            return $events;
        }
}