<?php 

namespace Stevebauman\Maintenance\Services;

use Recurr;
use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Models\Event;
use Stevebauman\Maintenance\Services\SentryService;

class EventService extends AbstractModelService {
	
	public function __construct(Event $event, SentryService $sentry){
		$this->model = $event;
		$this->sentry = $sentry;
        }
        
        public function create()
        {
            
            $this->dbStartTransaction();
            
            try {
            
                $insert = array(
                    'user_id'               => $this->sentry->getCurrentUserId(),
                    'title'                 => $this->getInput('title', true),
                    'description'           => $this->getInput('description', true),
                    'start'                 => $this->formatDateWithTime($this->getInput('start_date'), $this->getInput('start_time')),
                    'end'                   => $this->formatDateWithTime($this->getInput('end_date'), $this->getInput('end_time')),
                    'allDay'                => $this->getInput('all_day', 0),
                    'color'                 => $this->getInput('color'),
                    'background_color'      => $this->getInput('background_color'),
                    'recur_frequency'       => $this->getInput('recur_frequency'),
                    'recur_count'           => $this->getInput('recur_limit'),
                    'recur_filter_days'     => $this->getInput('recur_days'),
                    'recur_filter_months'   => $this->getInput('recur_months')
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
                    'recur_count'           => $this->getInput('recur_limit', $record->recur_count),
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
                
                $this->dbCommitTransaction();
                
                return false;
            
            } catch (Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
        }
        
        public function setRecurFilterDaysAttribute($value)
        {
            return $this->implodeArrayForRule($value);
        }
        
        public function setRecurFilterMonthsAttribute($value)
        {
            return $this->implodeArrayForRule($value);
        }
        
        public function setRecurFilterYearsAttribute($value)
        {
            return $this->implodeArrayForRule($value);
        }
        
        public function parseEvents($events, $data)
        {

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
        
        private function implodeArrayForRule($value)
        {
            
            if(isset($value) && is_array($value)){
                return implode(",", $value);
            } 
            
            return NULL;
        }
        
}