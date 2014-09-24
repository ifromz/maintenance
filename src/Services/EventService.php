<?php namespace Stevebauman\Maintenance\Services;

use Recurr;
use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Models\Event;
use Stevebauman\Maintenance\Services\SentryService;

class EventService extends AbstractModelService {
	
	public function __construct(Event $event, SentryService $sentry){
		$this->model = $event;
		$this->sentry = $sentry;
        }
        
        public function create($data){

            $insert = array(
                'user_id'               => $this->sentry->getCurrentUserId(),
                'title'                 => $this->input('title', true),
                'description'           => $this->input('description', true),
                'start'                 => $this->formatDateWithTime($this->input('start_date'), $this->input('start_time')),
                'end'                   => $this->formatDateWithTime($this->input('end_date'), $this->input('end_time')),
                'allDay'                => ($this->input('all_day') ?: 0),
                'color'                 => $this->input('color'),
                'background_color'      => $this->input('background_color'),
                'recur_frequency'       => $this->input('recur_frequency'),
                'recur_count'           => ($this->input('recur_limit') ?: NULL),
                'recur_filter_days'     => $this->input('recur_days'),
                'recur_filter_months'   => $this->input('recur_months')
            );
            
            if($record = $this->model->create($insert)){
                return $record;
            } return false;
            
        }
        
        public function update($id, $data){
            $record = $this->model->find($id);
            
            $insert = array(
                'title'                 => ($this->input('title', true) ?: $record->title),
                'description'           => ($this->input('description', true) ?: $record->description),
                'start'                 => ($this->formatDateWithTime($this->input('start_date'), $this->input('start_time')) ?: $record->start),
                'end'                   => ($this->formatDateWithTime($this->input('end_date'), $this->input('end_time')) ?: $record->end),
                'allDay'                => ($this->input('all_day') ?: 0),
                'color'                 => ($this->input('color') ?: $record->color),
                'background_color'      => ($this->input('background_color') ?: $record->background_color),
                'recur_frequency'       => ($this->input('recur_frequency') ?: $record->recur_frequency),
                'recur_count'           => ($this->input('recur_limit') ?: NULL),
                'recur_filter_days'     => ($this->input('recur_days') ?: $record->recur_filter_days),
                'recur_filter_months'   => ($this->input('recur_months') ?: $record->recur_filter_months)
            );
            
            
            
            if($record->update($insert)){
                return $record;
            } return false;
        }
        
        public function updateDates($id){
            $record = $this->model->find($id);
            
            $insert = array(
                'start' => $this->input('start'),
                'end'   => $this->input('end'),
                'allDay' => $this->input('all_day')
            );
            
            if($record->update($insert)){
                return $record;
            } return false;
        }
        
        
        
        public function setRecurFilterDaysAttribute($value){
            return $this->implodeArrayForRule($value);
        }
        
        public function setRecurFilterMonthsAttribute($value){
            return $this->implodeArrayForRule($value);
        }
        
        public function setRecurFilterYearsAttribute($value){
            return $this->implodeArrayForRule($value);
        }
        
        public function parseEvents($events, $data){

            foreach($events as $event){
                
                if($event->isRecurring()){

                    /*
                     * Check if the recurring ends by looking at the recur_count variable. 
                     * If it does, set the rule count for Recurr.
                     * 
                     * If the reucrring does not end, set the limit accordingly to 
                     * the recur_frequency so recurring events are limited and queries are faster.
                     */
                    if($event->recurringEnds()){
                        
                       $ruleStr = sprintf('FREQ=%s;COUNT=%s;', $event->recur_frequency, $event->recur_count);
                       $limit = NULL;
                       
                    } else{
                        $ruleStr = sprintf('FREQ=%s;', $event->recur_frequency);
                       
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
                    
                    $inputStart = new \DateTime($data['start'], new \DateTimeZone($timezone)) ;
                    $inputEnd = new \DateTime($data['end'], new \DateTimeZone($timezone)) ;
                    
                    $rule        = new Recurr\Rule($ruleStr, $startDate, $endDate, $timezone);
                    $transformer = new Recurr\Transformer\ArrayTransformer();
                    $constraint = new Recurr\Transformer\Constraint\BetweenConstraint($inputStart, $inputEnd);
                    
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
        
        private function implodeArrayForRule($value){
            if(isset($value) && is_array($value)){
                return implode(",", $value);
            } return NULL;
        }
        
}