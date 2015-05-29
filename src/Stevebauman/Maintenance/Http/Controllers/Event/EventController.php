<?php

namespace Stevebauman\Maintenance\Http\Controllers\Event;

use Stevebauman\Maintenance\Http\Requests\Event\Request;
use Stevebauman\Maintenance\Repositories\EventRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * @var EventRepository
     */
    protected $event;

    /**
     * @param EventRepository $event
     */
    public function __construct(EventRepository $event)
    {
        $this->event = $event;
    }

    /**
     * Displays all current events.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance::events.index');
    }

    /**
     * Displays the form for creating a new event.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('maintenance::events.create');
    }

    /**
     * Creates a new event.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function store(Request $request)
    {
        $event = $this->event->create($request);

        if($event) {
            $message = 'Successfully created event.';

            return redirect()->route('maintenance.events.index')->withSuccess($message);
        } else {
            $message = 'There was an issue creating an event. Please try again.';

            return redirect()->route('maintenance.events.create')->withErrors($message);
        }
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
