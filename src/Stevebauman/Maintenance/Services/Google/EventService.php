<?php

namespace Stevebauman\Maintenance\Services\Google;

use Stevebauman\EloquentTable\TableCollection;
use Stevebauman\CalendarHelper\Objects\Event;
use Stevebauman\CalendarHelper\CalendarHelper;
use Stevebauman\CoreHelper\Services\AbstractService;

/**
 * Handles Google Calendar Events much like the typical model services
 */
class EventService extends AbstractService {
    
    use \Stevebauman\EloquentTable\TableTrait;
    
    public function __construct(CalendarHelper $calendar)
    {
        $this->calendar = $calendar->google();
    }
    
    /**
     * Returns a google collection of all events from the inputted filter
     * 
     * @return Stevebauman\EloquentTable\TableCollection\TableCollection
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
        
        return new TableCollection($this->calendar->events($filter));
    }
    
    /**
     * Creates a google batch request for specific event ID's
     * 
     * @param type $ids
     * @return Stevebauman\EloquentTable\TableCollection\TableCollection
     */
    public function getOnly($ids = array())
    {
        return new TableCollection($this->calendar->specificEvents($ids));
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
        $event = new Event();
        
        /*
         * If recur until is specified, make sure to convert it to RFC2445 format
         * 
         * Recur frequency is mandatory, while other attributes are optional
         */
        $arrayRule = array(
            'FREQ'      => $this->getInput('recur_frequency'),
            'BYDAY'      => ($this->getInput('recur_days') ? $this->implodeArrayForRule($this->getInput('recur_days')) : NULL),
            'BYMONTH'    => ($this->getInput('recur_months') ? $this->implodeArrayForRule($this->getInput('recur_months')) : NULL),
            'UNTIL'     => ($this->getInput('recur_until') ? $this->strToRfc2445($this->getInput('recur_until')) : NULL),
        );
        
        /*
         * Convert the rule array to RRULE string
         */
        $rrule = $this->arrayToRRule($arrayRule);
        
        /*
         * Combine dates with their times
         */
        $start = $this->getInput('start_date'). ' ' . $this->getInput('start_time');
        $end = $this->getInput('end_date'). ' ' . $this->getInput('end_time');
        
        $allDay = $this->getInput('all_day');
        
        $event->rrule = $rrule;
        $event->title = $this->getInput('title');
        $event->location = $this->getInput('location');
        $event->start = $this->strToRfc3339($start, $allDay);
        $event->end = $this->strToRfc3339($end, $allDay, true);
        $event->allDay = $allDay;
        
        return $this->calendar->createEvent($event);
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
            * If recur until is specified, make sure to convert it to RFC2445 format
            * 
            * Recur frequency is mandatory, while other attributes are optional
            */
            $arrayRule = array(
                'FREQ'      => $this->getInput('recur_frequency'),
                'BYDAY'      => ($this->getInput('recur_days') ? $this->implodeArrayForRule($this->getInput('recur_days')) : NULL),
                'BYMONTH'    => ($this->getInput('recur_months') ? $this->implodeArrayForRule($this->getInput('recur_months')) : NULL),
                'UNTIL'     => ($this->getInput('recur_until') ? $this->strToRfc2445($this->getInput('recur_until')) : NULL),
            );

           /*
            * Convert the rule array to RRULE string
            */
            $rrule = $this->arrayToRRule($arrayRule);

           /*
            * Combine dates with their times
            */
            $start = $this->getInput('start_date'). ' ' . $this->getInput('start_time');
            $end = $this->getInput('end_date'). ' ' . $this->getInput('end_time');
            
            $allDay = $this->getInput('all_day');
            
            /*
             * Values set to events default
             */
            $event->title = $this->getInput('title', $event->apiObject->getSummary());
            $event->description = $this->getInput('description', $event->apiObject->getDescription());
            $event->location = $this->getInput('location', $event->apiObject->getLocation());
            $event->start = $this->strToRfc3339($start, $allDay);
            $event->end = $this->strToRfc3339($end, $allDay, true);
            $event->allDay = $allDay;
            $event->rrule = $rrule;
            
            return $this->calendar->updateEvent($event);
            
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
            
            $allDay = false;
            
            if($this->getInput('all_day') === 'true') {
                $allDay = true;
            }
            
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
            if(!$allDay){
                
                $start = $startDate->format(\DateTime::RFC3339);
                $end = $endDate->format(\DateTime::RFC3339);
                
            } else {
                
                $start = $startDate->format('Y-m-d');
                
                /*
                 * Add one day when POSTing to google for FullCalendar
                 * fix. FullCalendar treats end dates that are all day as a day
                 * before Google Calendar.
                 */
                $endDate->add(new \DateInterval('P1D'));
                $end = $endDate->format('Y-m-d');
                
            }
            
            /*
             * Set new event attributes
             */
            $event->start = $start;
            $event->end = $end;
            $event->allDay = $allDay;
            
            /*
             * Update and return the new event
             */
            return $this->calendar->updateEvent($event);
            
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
     * This is used for start/end dates for the creation/modification of events.
     * 
     * If $allDay and $isEnd are true, a day is added onto the date 
     * since the Google calendar thinks an all day event that spans
     * multiple days ends on the day before rather than consuming the day it
     * ends on.
     * 
     * Example: For an all day event that starts January 1st and ends January 3rd,
     * Google will end the event on the 2nd since the idea here is that the event
     * is 'till' the 3rd.
     * 
     * @param string $dateStr
     * @param boolean $allDay
     * @param boolean $isEnd
     * @return string
     */
    private function strToRfc3339($dateStr, $allDay = false, $isEnd = false)
    {
        $date = new \DateTime();
        
        $date->setTimestamp(strtotime($dateStr));
        
        /*
         * If the event is all day, google only accepts Y-m-d formats instead
         * of RFC3339
         */
        if($allDay) {
            
            if($isEnd) {
                $date->add(new \DateInterval('P1D'));
            }
            
            return $date->format('Y-m-d');
        } else {
            return $date->format(\DateTime::RFC3339);
        }
        
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
            
            $startDate = new \DateTime($event->start);
            $endDate = new \DateTime($event->end);
            
            if($event->allDay) {
                
                /*
                 * Subtract one day fix for FullCalendar
                 */
                $endDate->sub(new \DateInterval('P1D'));
                
            }
            
            /*
             * Add the event into a FullCalendar compatible array
             */
            $arrayEvents[] = array(
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->location,
                'start' => $startDate->format('Y-m-d H:i:s'),
                'end' => $endDate->format('Y-m-d H:i:s'),
                'allDay' => $event->allDay,
            );
        }
        
        return $arrayEvents;
    }
    
    
}