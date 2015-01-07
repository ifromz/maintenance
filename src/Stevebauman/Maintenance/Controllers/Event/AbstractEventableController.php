<?php

namespace Stevebauman\Maintenance\Controllers\Event;

use Stevebauman\Maintenance\Validators\Event\EventValidator;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Controllers\BaseController;

abstract class AbstractEventableController extends BaseController {

    /*
     * Holds the eventable resource
     */
    protected $eventable;

    /*
     * Holds the API calendar ID for the specific resource
     */
    protected $eventableCalendarId;

    public function __construct(EventService $event, EventValidator $eventValidator)
    {
        $this->event = $event;
        $this->eventValidator = $eventValidator;

        /*
         * If the eventableCalendarId is set from the child controller, we'll set the calendar ID for the API
         * so all operations on the API go to the right calendar
         */
        if($this->eventableCalendarId) {
            $this->event->eventApi->setCalendar($this->eventableCalendarId);
        }
    }

    /**
     * @param string $eventable_id
     * @return mixed
     */
    public function index($eventable_id)
    {
        $eventable = $this->eventable->find($eventable_id);

        $events = $this->event->getApiEvents($eventable->events->lists('api_id'));

        return view('maintenance::events.eventable.index', array(
            'title' => 'Events',
            'eventable' => $eventable,
            'events' => $events,
        ));
    }

    /**
     * @param string $eventable_id
     * @return mixed
     */
    public function create($eventable_id)
    {
        $eventable = $this->eventable->find($eventable_id);

        return view('maintenance::events.eventable.create', array(
            'title' => 'Create Event',
            'eventable' => $eventable,
        ));
    }

    /**
     * @param string $eventable_id
     * @return \Illuminate\Support\Facades\Response
     */
    public function store($eventable_id)
    {
        if($this->eventValidator->passes()) {

            $eventable = $this->eventable->find($eventable_id);

            $event = $this->event->setInput($this->inputAll())->create();

            if($event) {

                $localEvent = $this->event->findLocalByApiId($event->id);

                $eventable->events()->attach($localEvent);

                $this->message = sprintf('Successfully created event. %s', link_to_action(currentControllerAction('show'), 'Show', array($eventable->id, $event->id)));
                $this->messageType = 'success';
                $this->redirect = action(currentControllerAction('show'), array($eventable->id, $event->id));

            } else {

                $this->message = 'There was an error trying to create an event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect =  action(currentControllerAction('create'), array($eventable->id));

            }

        } else {

            $this->redirect = action(currentControllerAction('create'), array($eventable_id));
            $this->errors = $this->eventValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * @param string $eventable_id
     * @param string $api_id
     * @return mixed
     */
    public function show($eventable_id, $api_id)
    {
        $eventable = $this->eventable->find($eventable_id);

        $event = $this->event->findByApiId($api_id);

        $localEvent = $this->event->findLocalByApiId($api_id);

        /*
         * Filter recurrences to display entries one month from now
         */
        $data = array(
            'timeMin' => strToRfc3339(strtotime('now')),
            'timeMax' => strToRfc3339(strtotime('+1 month')),
        );

        $recurrences = $this->event->setInput($data)->getRecurrencesByApiId($api_id);

        return view('maintenance::events.eventable.show', array(
            'title' => 'Viewing Event: '.$event->title,
            'event' => $event,
            'localEvent' => $localEvent,
            'eventable' => $eventable,
            'recurrences' => $recurrences,
        ));
    }

    /**
     * @param string $eventable_id
     * @param string $api_id
     * @return mixed
     */
    public function edit($eventable_id, $api_id)
    {
        $eventable = $this->eventable->find($eventable_id);

        $event = $this->event->findByApiId($api_id);

        return view('maintenance::events.eventable.edit', array(
            'title' => sprintf('Editing event %s', $event->title),
            'eventable' => $eventable,
            'event' => $event,
        ));
    }

    /**
     * @param string $eventable_id
     * @param string $api_id
     */
    public function update($eventable_id, $api_id)
    {
        if($this->eventValidator->passes()) {

            $eventable = $this->eventable->find($eventable_id);

            $event = $this->event->setInput($this->inputAll())->updateByApiId($api_id);

            if($event) {

                $this->message = sprintf('Successfully updated event. %s', link_to_action(currentControllerAction('show'), 'Show', array($eventable->id, $event->id)));
                $this->messageType = 'success';
                $this->redirect = action(currentControllerAction('show'), array($eventable->id, $event->id));

            } else {

                $this->message = 'There was an error trying to udpdate this event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = action(currentControllerAction('edit'), array($eventable->id, $event->id));

            }

        } else {

            $this->redirect = action(currentControllerAction('edit'), array($eventable_id));
            $this->errors = $this->eventValidator->getErrors();

        }

        return $this->response();
    }

    /**
     * @param string $eventable_id
     * @param string $api_id
     */
    public function destroy($eventable_id, $api_id)
    {
        if($this->event->destroyByApiId($api_id)) {

            $this->message = 'Successfully deleted event';
            $this->messageType = 'success';
            $this->redirect = action(currentControllerAction('index'), array($eventable_id));

        } else {

            $this->message = 'There was an error trying to delete this event. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = action(currentControllerAction('show'), array($eventable_id, $api_id));

        }

        return $this->response();
    }

}