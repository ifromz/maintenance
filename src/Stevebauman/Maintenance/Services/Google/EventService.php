<?php

namespace Stevebauman\Maintenance\Services\Google;

use Stevebauman\CalendarHelper\CalendarHelper;
use Stevebauman\CoreHelper\Services\AbstractService;

/**
 * Handles Google Calendar Events much like the typical model services
 */
class EventService extends AbstractService {
    
    public function __construct(CalendarHelper $calendar)
    {
        $this->calendar = $calendar->google();
    }
    
    /**
     * Returns a google collection of all events from the inputted filter
     * 
     * @return type
     */
    public function get()
    {
        $filter = array(
            'alwaysIncludeEmail'    => $this->getInput('alwaysIncludeEmail', false),
            'iCalUID'               => $this->getInput('iCalUID'),
            'maxAttendees'          => $this->getInput('maxAttendees'),
            'maxResults'            => $this->getInput('maxResults'),
            'orderBy'               => $this->getInput('orderBy'),
            'pageToken'             => $this->getInput('pageToken'),
            'singleEvents'          => $this->getInput('singleEvents', true),
            'timeMin'               => $this->getInput('timeMin'),
            'timeMax'               => $this->getInput('timeMax'),
        );

        return $this->calendar->events($filter);
    }
    
    public function getOnly($ids = array())
    {
        return $this->calendar->specificEvents($ids);
    }
    
    /**
     * Returns the specified google calendar event
     * 
     * @param type $id
     * @return type
     */
    public function find($id)
    {
        return $this->calendar->event($id);
    }
    
    /**
     * Creates a new google calendar event
     * 
     * @return type
     */
    public function create()
    {   
        /*
         * If recur until is specified, make sure to convert it to RFC2445 format
         * 
         * Recur frequency is mandatory, while other attributes are optional
         */
        $arrayRule = array(
            'FREQ'      => $this->getInput('recur_frequency'),
            'DAYS'      => ($this->getInput('recur_days') ? $this->implodeArrayForRule($this->getInput('recur_days')) : NULL),
            'MONTHS'    => ($this->getInput('recur_months') ? $this->implodeArrayForRule($this->getInput('recur_months')) : NULL),
            'UNTIL'     => ($this->getInput('recur_until') ? $this->strToRfc2445($this->getInput('recur_until')) : NULL),
        );
        
        $rrule = $this->arrayToRRule($arrayRule);
        
        $insert = array(
            'summary'       => $this->getInput('title'),
            'description'   => $this->getInput('description'),
            'location'      => $this->getInput('location'),
            'start'         => $this->strToRfc3339($this->getInput('start')),
            'end'           => $this->strToRfc3339($this->getInput('end')),
            'timeZone'      => $this->getInput('timeZone', config('app.timezone')),
            'allDay'        => $this->getInput('allDay'),
            'rrule'         => $rrule,
        );
        
        
        return $this->calendar->createEvent($insert);
    }
    
    /**
     * Updates the specified google calendar event
     * 
     * @param string $id
     * @return boolean
     */
    public function update($id)
    {
        $event = $this->find($id);
        
        if($event) {
            
            /*
             * Values set to events default
             */
            $insert = array(
                'summary'       => $this->getInput('title', $event->getSummary()),
                'description'   => $this->getInput('description', $event->getDescription()),
                'location'      => $this->getInput('location', $event->getLocation()),
                'start'         => $this->strToRfc3339($this->getInput('start')),
                'end'           => $this->strToRfc3339($this->getInput('end')),
                'timeZone'      => $this->getInput('timeZone', config('app.timezone')),
            );
            
            return $this->calendar->updateEvent($event, $insert);
            
        }
        
        return false;
        
    }
    
    /**
     * Updates the start and end dates of the specified google calendar event
     * 
     * @param string $id
     * @return boolean
     */
    public function updateDates($id)
    {
        $event = $this->find($id);
        
        if($event) {
            
            $startDate = new \DateTime($this->getInput('start'));
            
            /*
             * FullCalendar doesn't post end date if all day event
             * ends on the same day
             */
            if($this->getInput('end')) {
                $endDate = new \DateTime($this->getInput('end'));
            } else {
                $endDate = $startDate;
            }
            
            /*
             * If google event is all day, dateTime attribute will be NULL
             */
            if($event->getStart()->dateTime){
                $start = $startDate->format(\DateTime::RFC3339);
            } else {
                $start = $startDate->format('Y-m-d');
            }
            
            /*
             * Same thing for end date. If dateTime is NULL, the event is all day
             */
            if($event->getEnd()->dateTime){
                $end = $endDate->format(\DateTime::RFC3339);
            } else {
                
                /*
                 * Add one day when POSTing to google for FullCalendar
                 * fix. FullCalendar treats end dates that are all day as a day
                 * before Google Calendar.
                 */
                $endDate->add(new \DateInterval('P1D'));
                $end = $endDate->format('Y-m-d');

            }
            
            /*
             * FullCalendar JSON all_day boolean to PHP bool
             */
            if($this->getInput('all_day') === 'true') {
                $allDay = true;
            } else {
                $allDay = false;
            }
            
            $insert = array(
                'start' => $start,
                'end' => $end,
                'timeZone' => config('app.timezone'),
                'allDay' => $allDay
            );
            
            return $this->calendar->updateEvent($event, $insert);
            
        }
        
        return false;
    }
    
    /**
     * Deletes the specified google calendar event
     * 
     * @param string $id
     * @return type
     */
    public function destroy($id)
    {
        return $this->calendar->deleteEvent($id);
    }
    
    /**
     * Converts a date string into RFC3339 format for google calendar api.
     * This is used for start/end dates for the creation/modification of events
     */
    private function strToRfc3339($dateStr)
    {
        $date = new \DateTime();
        
        $date->setTimestamp(strtotime($dateStr));
        
        return $date->format(\DateTime::RFC3339);
    }
    
    /**
     * Converts a date string into RFC2445 format for google calendar api.
     * This is used for recurrance rule dates
     */
    private function strToRfc2445($dateStr)
    {
        $date = new \DateTime();
        
        $date->setTimestamp(strtotime($dateStr));
        
        return $date->format('Ymd\THis\Z');
    }
    
    /**
     * Converts an array of recurring event rules to an RRULE string
     * 
     * @param array $rules
     */
    private function arrayToRRule(array $rules = array())
    {
        $ruleString = '';
        
        /*
         * If rules exist in the array
         */
        if(count($rules) > 0) {
            
            foreach($rules as $rule => $value) {
                
                /*
                 * Make sure the value of the rule isn't empty
                 */
                if(!empty($value)) {
                    
                    /*
                     * Add the rule onto the string
                     */
                    $ruleString .= strtoupper($rule) . '=' . $value . ';';
                    
                }
            }
            
            /*
             * Check if there are actually any arguements in the rule string
             * by checking the length. If there are, add the required RRULE prefix
             */
            if(strlen($ruleString) > 0) {
                $ruleString = 'RRULE:'.$ruleString;
            }
        
        }
        
        return $ruleString;
    }
    
    /**
     * Converts an array from the multi-select inputs to a comma seperated list
     * for use in the RRule rule string
     * 
     * @param array $values
     * @return null OR string
     */
    private function implodeArrayForRule(array $values = array())
    {
        /*
         * If a value is given, and it's an array, implode the array by comma
         * converting it into a comma seperated string.
         * 
         * Ex. array(0 => 'MO', 1 => 'TU', 2 => 'WE') = 'MO,TU,WE'
         */
        if(isset($values) && is_array($values)){
            return implode(",", $values);
        } 

        return NULL;
    }
    
    /**
     * Parses a google collection of events into an array of events compatible
     * with FullCalendar
     * 
     * @param collection $events
     * @return type
     */
    public function parseEvents($events)
    {   
        $arrayEvents = array();
        
        foreach($events as $event) {
            
            $allDay = false;
            
            if($event->getStart()->dateTime) {
                $startDate = new \DateTime($event->getStart()->dateTime);
            } else {
                $allDay = true;
                $startDate = new \DateTime($event->getStart()->date);
            }
            
            if($event->getEnd()->dateTime) {
                $endDate = new \DateTime($event->getEnd()->dateTime);

            } else {
                $allDay = true;
                $endDate = new \DateTime($event->getEnd()->date);
                
                /*
                 * Subtract one day fix for FullCalendar
                 */
                $endDate->sub(new \DateInterval('P1D'));
            }
            
            $arrayEvents[] = array(
                'id' => $event->getId(),
                'title' => $event->getSummary(),
                'description' => $event->getLocation(),
                'start' => $startDate->format('Y-m-d H:i:s'),
                'end' => $endDate->format('Y-m-d H:i:s'),
                'allDay' => $allDay,
            );
        }
        
        return $arrayEvents;
    }
    
}