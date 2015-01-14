<?php

namespace Stevebauman\Maintenance\Services\Google;

use Stevebauman\EloquentTable\TableCollection;
use Stevebauman\EloquentTable\TableTrait;
use Stevebauman\CalendarHelper\Objects\Event;
use Stevebauman\CalendarHelper\CalendarHelper;
use Stevebauman\CoreHelper\Services\AbstractService;

/**
 * Handles Google Calendar Events much like the typical model services
 */
class EventService extends AbstractService
{

    use TableTrait;

    public function __construct(CalendarHelper $calendar, TableCollection $collection)
    {
        $this->calendar = $calendar->google();
        $this->collection = $collection;
    }

    /**
     * Sets the Google Calendar to perform operations on
     *
     * @param string $id
     * @return $this
     */
    public function setCalendar($id)
    {
        return $this->calendar->setCalendarId($id);
    }

    /**
     * Returns a google collection of all events from the inputted filter
     *
     * @return mixed
     */
    public function get()
    {
        $events = $this->calendar->events($this->getEventsFilter());

        return new $this->collection($events);
    }

    /**
     * Returns param array for querying google events
     *
     * @return array
     */
    private function getEventsFilter()
    {
        $filter = array(
            'singleEvents' => $this->getInput('singleEvents', true),
            'orderBy' => $this->getInput('orderBy'),
        );

        return array_merge($filter, $this->getBaseFilter());
    }

    /**
     * Returns a base event filter for google API
     *
     * @return array
     */
    private function getBaseFilter()
    {
        $filter = array(
            'alwaysIncludeEmail' => $this->getInput('alwaysIncludeEmail', false),
            'maxAttendees' => $this->getInput('maxAttendees'),
            'maxResults' => $this->getInput('maxResults'),
            'pageToken' => $this->getInput('pageToken'),
            'showDeleted' => $this->getInput('showDeleted', false),
            'timeMin' => $this->getInput('timeMin'),
            'timeMax' => $this->getInput('timeMax'),
        );

        return $filter;
    }

    /**
     * Returns recurrences of the specified ID
     *
     * @param string $id
     * @return mixed
     */
    public function getRecurrences($id)
    {
        $events = $this->calendar->recurrences($id, $this->getRecurringEventsFilter());

        return new $this->collection($events);
    }

    /**
     * Returns param array for querying google event recurrences
     *
     * @return array
     */
    private function getRecurringEventsFilter()
    {
        $filter = array(
            'originalStart' => $this->getInput('originalStart'),
        );

        return array_merge($filter, $this->getBaseFilter());
    }

    /**
     * Creates a google batch request for specific event ID's
     *
     * @param array $ids
     * @return \Stevebauman\EloquentTable\TableCollection
     */
    public function getOnly($ids = array(), $recurrences = false)
    {
        $events = $this->calendar->specificEvents($ids, $recurrences, $this->getRecurringEventsFilter());

        foreach ($events as &$event) {

            if ($event->attendees) {
                $event->attendees = new $this->collection($event->attendees);
            }

        }

        return new $this->collection($events);
    }

    /**
     * Creates a new google calendar event
     *
     * @return type
     */
    public function create()
    {
        /*
         * Convert the rule array to RRULE string
         */
        $rrule = $this->arrayToRRule($this->getArrayRules());

        /*
         * Combine dates with their times
         */
        $start = $this->getInput('start_date') . ' ' . $this->getInput('start_time');
        $end = $this->getInput('end_date') . ' ' . $this->getInput('end_time');

        if ($this->getInput('all_day') === 'true') {
            $allDay = true;
        } else {
            $allDay = false;
        }

        $event = new Event(array(
            'title' => $this->getInput('title'),
            'location' => $this->getInput('location'),
            'start' => strToRfc3339($start, $allDay),
            'end' => strToRfc3339($end, $allDay, true),
            'all_day' => $allDay,
            'rrule' => $rrule
        ));

        return $this->calendar->createEvent($event);
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
        if (count($rules) > 0) {

            foreach ($rules as $rule => $value) {

                /*
                 * Make sure the value of the rule isn't empty
                 */
                if (!empty($value)) {

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
            if (strlen($ruleString) > 0) {
                $ruleString = 'RRULE:' . $ruleString;
            }

        }

        return $ruleString;
    }

    /**
     * Returns a google api RRULE compatible array
     *
     * @return array
     */
    private function getArrayRules()
    {
        /*
        * If recur until is specified, make sure to convert it to RFC2445 format
        *
        * Recur frequency is mandatory, while other attributes are optional
        */
        $arrayRule = array(
            'FREQ' => $this->getInput('recur_frequency'),
            'BYDAY' => ($this->getInput('recur_days') ? $this->implodeArrayForRule($this->getInput('recur_days')) : NULL),
            'BYMONTH' => ($this->getInput('recur_months') ? $this->implodeArrayForRule($this->getInput('recur_months')) : NULL),
            'UNTIL' => ($this->getInput('recur_until') ? strToRfc2445($this->getInput('recur_until')) : NULL),
        );

        return $arrayRule;
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
        if (isset($values) && is_array($values)) {
            return implode(",", $values);
        }

        return NULL;
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

        if ($event) {

            /*
             * Convert the rule array to RRULE string
             */
            $rrule = $this->arrayToRRule($this->getArrayRules());

            /*
             * Combine dates with their times
             */
            $start = $this->getInput('start_date') . ' ' . $this->getInput('start_time');
            $end = $this->getInput('end_date') . ' ' . $this->getInput('end_time');

            $allDay = $this->getInput('all_day');

            /*
             * Values set to events default
             */
            $event->title = $this->getInput('title', $event->apiObject->getSummary());
            $event->description = $this->getInput('description', $event->apiObject->getDescription());
            $event->location = $this->getInput('location', $event->apiObject->getLocation());
            $event->start = strToRfc3339($start, $allDay);
            $event->end = strToRfc3339($end, $allDay, true);
            $event->allDay = $allDay;
            $event->rrule = $rrule;

            return $this->calendar->updateEvent($event);

        }

        return false;

    }

    /**
     * Returns the specified google calendar event
     *
     * @param string $id
     * @return mixed
     */
    public function find($id)
    {
        $event = $this->calendar->event($id);

        if ($event->status !== 'cancelled') {

            $event->attendees = new $this->collection($event->attendees);

            return $event;

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

        if ($event) {

            $allDay = false;

            if ($this->getInput('all_day') === 'true') {
                $allDay = true;
            }

            $startDate = new \DateTime($this->getInput('start'));

            /*
             * FullCalendar doesn't post end date if all day event
             * ends on the same day
             */
            if ($this->getInput('end')) {
                $endDate = new \DateTime($this->getInput('end'));
            } else {
                $endDate = $startDate;
            }

            /*
             * If google event is all day, dateTime attribute will be NULL
             */
            if (!$allDay) {

                $start = $startDate->format(\DateTime::RFC3339);
                $end = $endDate->format(\DateTime::RFC3339);

            } else {

                $start = $startDate->format('Y-m-d');

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

}