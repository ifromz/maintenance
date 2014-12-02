<?php 

namespace Stevebauman\Maintenance\Services\Calendar;

use Recurr;
use Stevebauman\Maintenance\Exceptions\AssetEventNotFoundException;
use Stevebauman\Maintenance\Models\CalendarEvent;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\BaseModelService;

class EventService extends BaseModelService {
	
        /*
         * AssetEventNotFoundException to be changed
         */
	public function __construct(CalendarEvent $event, SentryService $sentry, AssetEventNotFoundException $notFoundException){
		$this->model = $event;
		$this->sentry = $sentry;
                $this->notFoundException = $notFoundException;
        }
        
        public function getRecurrencesByPage($parent_id)
        {
            return $this->model
                    ->where('parent_id', $parent_id)
                    ->paginate(25);
        }
        
        public function create()
        {
            
            $this->dbStartTransaction();
            
            try {
            
                $insert = array(
                    'parent_id'             => $this->getInput('parent_id', NULL),
                    'user_id'               => $this->sentry->getCurrentUserId(),
                    'title'                 => $this->getInput('title', NULL, true),
                    'description'           => $this->getInput('description', NULL, true),
                    'start'                 => $this->formatDateWithTime($this->getInput('start_date'), $this->getInput('start_time')),
                    'end'                   => $this->formatDateWithTime($this->getInput('end_date'), $this->getInput('end_time')),
                    'allDay'                => $this->getInput('all_day', 0),
                    'color'                 => $this->getInput('color'),
                    'background_color'      => $this->getInput('background_color'),
                    'recur_frequency'       => $this->getInput('recur_frequency', NULL),
                    'recur_filter_days'     => $this->implodeArrayForRule($this->getInput('recur_days', NULL)),
                    'recur_filter_months'   => $this->implodeArrayForRule($this->getInput('recur_months', NULL))
                );

                $record = $this->model->create($insert);

                $this->dbCommitTransaction();

                return $record;
               
            
            } catch (Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
            
        }
        
        public function update($id)
        {
            
            $this->dbStartTransaction();
            
            try {

                $record = $this->model->find($id);

                $insert = array(
                    'title'                 => $this->getInput('title', $record->title, true),
                    'description'           => $this->getInput('description', $record->description, true),
                    'start'                 => ($this->formatDateWithTime($this->getInput('start_date'), $this->getInput('start_time')) ?: $record->start),
                    'end'                   => ($this->formatDateWithTime($this->getInput('end_date'), $this->getInput('end_time')) ?: $record->end),
                    'allDay'                => $this->getInput('all_day', $record->allDay),
                    'color'                 => $this->getInput('color', $record->color),
                    'background_color'      => $this->getInput('background_color', $record->background_color),
                    'recur_frequency'       => $this->getInput('recur_frequency', $record->recur_frequency),
                    'recur_filter_days'     => $this->getInput('recur_days', $record->recur_filter_days),
                    'recur_filter_months'   => $this->getInput('recur_months', $record->recur_filter_months)
                );

                if($record->update($insert)){

                    $this->dbCommitTransaction();

                    return $record;
                }
                
                $this->dbRollbackTransaction();
                
                return false;
            
            } catch (Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
        }
        
        /**
         * Updates the dates of the event specifically for FullCalendar modifications
         * (resisizing and moving events around)
         * 
         * @param integer $id
         * @return boolean OR object
         */
        public function updateDates($id)
        {
            
            $this->dbStartTransaction();
            
            try {
            
                $record = $this->model->find($id);

                $insert = array(
                    'start' => $this->getInput('start'),
                    'end'   => $this->getInput('end'),
                    'allDay' => $this->getInput('all_day')
                );

                if($record->update($insert)){
                    
                    $this->dbCommitTransaction();
                    
                    return $record;
                }
                
                $this->dbRollbackTransaction();
                
                return false;
            
            } catch (Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
        }
        
        /**
         * Run the inputted days array through the implode to convert 
         * it to comma seperated string
         * 
         * @param array $value
         * @return string
         */
        public function setRecurFilterDaysAttribute($value)
        {
            return $this->implodeArrayForRule($value);
        }
        
        /**
         * Run the inputted months array through the implode to convert 
         * it to comma seperated string
         * 
         * @param array $value
         * @return string
         */
        public function setRecurFilterMonthsAttribute($value)
        {
            return $this->implodeArrayForRule($value);
        }
        
        /**
         * Run the inputted years array through the implode to convert 
         * it to comma seperated string
         * 
         * @param array $value
         * @return string
         */
        public function setRecurFilterYearsAttribute($value)
        {
            return $this->implodeArrayForRule($value);
        }
        
        /**
         * Accepts an eloquent collection of events as well as a data array for the input start and end date.
         * It will then check each event if it is recurring, and if it is, it will 
         * generate recurrances between the input start and end date.
         * 
         * @param collection $events
         * @param array $data
         * @return type
         */
        public function parseEvents($events, $data)
        {

            foreach($events as $event){
                
                if($event->isRecurring()){
                  
                    $ruleStr = sprintf('FREQ=%s;', $event->recur_frequency);
                    
                    /*
                     * Check Filters on events. Ex. If the scheduled event avoids weekends or certain days/holidays.
                     * Add each filter onto rule if set.
                     */
                    if(isset($event->recur_filter_days)){
                        $ruleStr .= sprintf('BYDAY=%s;', $event->recur_filter_days);
                    }
                    
                    if(isset($event->recur_filter_months)){
                        $ruleStr .= sprintf('BYMONTH=%s;', $event->recur_filter_months);
                    }
                    
                    if(isset($event->recur_filter_years)){
                        $ruleStr .= sprintf('BYYEAR=%s;', $event->recur_filter_years);
                    }
                    
                    /*
                     * Get the laravel timezone from the config
                     */
                    $timezone    = config('app.timezone'); // Set default timezone
                    
                    /*
                     * Create a new DateTime object for the events start and end date
                     */
                    $startDate   = new \DateTime($event->recur_start, new \DateTimeZone($timezone));
                    $endDate     = new \DateTime($event->recur_end, new \DateTimeZone($timezone));
                    
                    /*
                     * Create a new DateTime object for the input start and end date
                     */
                    $inputStart = new \DateTime($data['start'], new \DateTimeZone($timezone)) ;
                    $inputEnd = new \DateTime($data['end'], new \DateTimeZone($timezone)) ;
                    
                    /*
                     * Create rule object and apply constraint with input start and end DateTime objects
                     */
                    $rule        = new Recurr\Rule($ruleStr, $startDate, $endDate, $timezone);
                    $transformer = new Recurr\Transformer\ArrayTransformer();
                    $constraint = new Recurr\Transformer\Constraint\BetweenConstraint($inputStart, $inputEnd);
                    
                    /*
                     * Generate recurrances applying the rule and the constraint
                     */
                    $recurrances = $transformer->transform($rule, NULL, $constraint);
                    
                    foreach($recurrances as $recurrance){
                        
                        /*
                         * Get the existing occurance for this event
                         */
                        $existingOccurance = $this->where('parent_id', $event->id)
                                ->where('start', 'LIKE', '%'.$recurrance->getStart()->format('Y-m-d').'%')
                                ->where('end', 'LIKE', '%'.$recurrance->getEnd()->format('Y-m-d').'%')
                                ->get()
                                ->first();
                        
                        
                        /*
                         * If an occurance doesn't exist, create one
                         */
                        if(!$existingOccurance) {
                            
                            $data = array(
                                'parent_id' => $event->id,
                                'user_id' => $event->user_id,
                                'title' => $event->title,
                                'description' => $event->description,
                                'start' => $recurrance->getStart()->format('Y-m-d H:i:s'),
                                'end' => $recurrance->getEnd()->format('Y-m-d H:i:s'),
                                'allDay' => $event->allDay,
                                'color' => $event->color,
                                'backgroundColor' => $event->backgroundColor,
                            );
                            
                            $record = $this->model->create($data);
                            
                            $events[] = $record;
                            
                        }
                        
                    }
                    
                }
            }
            
            return $events;
        }
        
        /**
         * Converts an array from the multi-select inputs to a comma seperated list
         * for use in the Recurr rule object
         * 
         * @param array $value
         * @return null OR string
         */
        private function implodeArrayForRule($value)
        {
            
            if(isset($value) && is_array($value)){
                return implode(",", $value);
            } 
            
            return NULL;
        }
        
}