<?php

namespace Stevebauman\Maintenance\Http\Controllers\Event;

use Stevebauman\Maintenance\Validators\Event\EventValidator;
use Stevebauman\Maintenance\Services\LocationService;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Http\Controllers\Controller;

class EventController extends Controller
{
    public function __construct(EventService $event, LocationService $location, EventValidator $eventValidator)
    {
        $this->event = $event;
        $this->location = $location;
        $this->eventValidator = $eventValidator;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $events = $this->event->get();

        return view('maintenance::events.index', [
            'title' => 'Events',
            'events' => $events,
        ]);
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('maintenance::events.create', [
            'title' => 'Create an Event',
        ]);
    }

    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function store()
    {
        if ($this->eventValidator->passes()) {
            $event = $this->event->setInput($this->inputAll())->create();

            if ($event) {
                $this->message = sprintf('Successfully created event. %s', link_to_route('maintenance.events.show', 'Show', [$event->id]));
                $this->messageType = 'success';
                $this->redirect = route('maintenance.events.index');
            } else {
                $this->message = 'There was an error trying to create an event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.events.create');
            }
        } else {
            $this->redirect = route('maintenance.events.create');
            $this->errors = $this->eventValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * @param string $api_id
     *
     * @return mixed
     */
    public function show($api_id)
    {
        $event = $this->event->findByApiId($api_id);

        $localEvent = $this->event->findLocalByApiId($api_id);

        /*
         * Filter recurrences to display entries one month from now
         */
        $filter = [
            'timeMin' => strToRfc3339(strtotime('now')),
            'timeMax' => strToRfc3339(strtotime('+1 month')),
        ];

        $recurrences = $this->event->setInput($filter)->getRecurrencesByApiId($api_id);

        return view('maintenance::events.show', [
            'title' => 'Viewing Event: '.$event->title,
            'event' => $event,
            'localEvent' => $localEvent,
            'recurrences' => $recurrences,
        ]);
    }

    /**
     * @param string $api_id
     *
     * @return mixed
     */
    public function edit($api_id)
    {
        $event = $this->event->findByApiId($api_id);

        return view('maintenance::events.edit', [
            'title' => sprintf('Editing event %s', $event->title),
            'event' => $event,
        ]);
    }

    /**
     * @param string $api_id
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function update($api_id)
    {
        if ($this->eventValidator->passes()) {
            $event = $this->event->setInput($this->inputAll())->updateByApiId($api_id);

            if ($event) {
                $this->message = 'Successfully updated event';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.events.show', [$event->id]);
            } else {
                $this->message = 'There was an error trying to udpdate this event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.events.edit', [$api_id]);
            }
        } else {
            $this->redirect = route('maintenance.events.edit', [$api_id]);
            $this->errors = $this->eventValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * @param string $api_id
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function destroy($api_id)
    {
        if ($this->event->destroyByApiId($api_id)) {
            $this->message = 'Successfully deleted event';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.events.index');
        } else {
            $this->message = 'There was an error trying to delete this event. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.events.show', [$api_id]);
        }

        return $this->response();
    }
}
