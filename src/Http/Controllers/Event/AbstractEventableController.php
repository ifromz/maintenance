<?php

namespace Stevebauman\Maintenance\Http\Controllers\Event;

use Stevebauman\Maintenance\Validators\Event\EventValidator;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Http\Controllers\Controller;

abstract class AbstractEventableController extends Controller
{
    /*
     * Holds the eventable resource
     */
    protected $eventable;

    /**
     * The eventable's routes.
     *
     * @var array
     */
    protected $routes = [];

    /*
     * Holds the API calendar ID for the specific resource
     */
    protected $eventableCalendarId;

    /**
     * Constructor.
     *
     * @param EventService $event
     * @param EventValidator $eventValidator
     */
    public function __construct(EventService $event, EventValidator $eventValidator)
    {
        $this->event = $event;
        $this->eventValidator = $eventValidator;

        /*
         * If the eventableCalendarId is set from the child controller, we'll set the calendar ID for the API
         * so all operations on the API go to the right calendar
         */
        if ($this->eventableCalendarId) {
            $this->event->eventApi->setCalendar($this->eventableCalendarId);
        }
    }

    /**
     * @param int|string $eventableId
     *
     * @return \Illuminate\View\View
     */
    public function index($eventableId)
    {
        $eventable = $this->eventable->find($eventableId);

        $events = $this->event->getApiEvents($eventable->events->lists('api_id'));

        $routes = $this->routes;

        return view('maintenance::events.eventables.index', compact('events', 'eventable', 'routes'));
    }

    /**
     * @param string $eventableId
     *
     * @return \Illuminate\View\View
     */
    public function create($eventableId)
    {
        $eventable = $this->eventable->find($eventableId);

        $routes = $this->routes;

        return view('maintenance::events.eventables.create', compact('eventable', 'routes'));
    }

    /**
     * @param int|string $eventableId
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function store($eventableId)
    {
        if ($this->eventValidator->passes()) {
            $eventable = $this->eventable->find($eventableId);

            $event = $this->event->setInput($this->inputAll())->create();

            if ($event) {
                $localEvent = $this->event->findLocalByApiId($event->id);

                $eventable->events()->sync($localEvent);

                $this->message = sprintf('Successfully created event. %s', link_to_route($this->routes['show'], 'Show', [$eventable->id, $event->id]));
                $this->messageType = 'success';
                $this->redirect = route($this->routes['show'], [$eventable->id, $event->id]);
            } else {
                $this->message = 'There was an error trying to create an event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = action($this->routes['create'], [$eventable->id]);
            }
        } else {
            $this->redirect = route($this->routes['create'], [$eventableId]);
            $this->errors = $this->eventValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * @param string $eventable_id
     * @param string $api_id
     *
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
        $data = [
            'timeMin' => strToRfc3339(strtotime('now')),
            'timeMax' => strToRfc3339(strtotime('+1 month')),
        ];

        $recurrences = $this->event->setInput($data)->getRecurrencesByApiId($api_id);

        return view('maintenance::events.eventables.show', [
            'title' => 'Viewing Event: '.$event->title,
            'event' => $event,
            'localEvent' => $localEvent,
            'eventable' => $eventable,
            'recurrences' => $recurrences,
        ]);
    }

    /**
     * @param string $eventable_id
     * @param string $api_id
     *
     * @return mixed
     */
    public function edit($eventable_id, $api_id)
    {
        $eventable = $this->eventable->find($eventable_id);

        $event = $this->event->findByApiId($api_id);

        return view('maintenance::events.eventables.edit', [
            'title' => sprintf('Editing event %s', $event->title),
            'eventable' => $eventable,
            'event' => $event,
        ]);
    }

    /**
     * @param string $eventable_id
     * @param string $api_id
     */
    public function update($eventable_id, $api_id)
    {
        if ($this->eventValidator->passes()) {
            $eventable = $this->eventable->find($eventable_id);

            $event = $this->event->setInput($this->inputAll())->updateByApiId($api_id);

            if ($event) {
                $this->message = sprintf('Successfully updated event. %s', link_to_action(currentControllerAction('show'), 'Show', [$eventable->id, $event->id]));
                $this->messageType = 'success';
                $this->redirect = action(currentControllerAction('show'), [$eventable->id, $event->id]);
            } else {
                $this->message = 'There was an error trying to udpdate this event. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = action(currentControllerAction('edit'), [$eventable->id, $event->id]);
            }
        } else {
            $this->redirect = action(currentControllerAction('edit'), [$eventable_id]);
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
        if ($this->event->destroyByApiId($api_id)) {
            $this->message = 'Successfully deleted event';
            $this->messageType = 'success';
            $this->redirect = action(currentControllerAction('index'), [$eventable_id]);
        } else {
            $this->message = 'There was an error trying to delete this event. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = action(currentControllerAction('show'), [$eventable_id, $api_id]);
        }

        return $this->response();
    }
}
