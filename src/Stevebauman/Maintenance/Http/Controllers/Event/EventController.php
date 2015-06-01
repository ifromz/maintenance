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
     * Displays the specified event.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $event = $this->event->find($id);

        $apiObject = $this->event->findApiObject($event->api_id);

        return view('maintenance::events.show', compact('event', 'apiObject'));
    }

    /**
     * Displays the form for editing the specified event.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function edit($id)
    {
        $event = $this->event->find($id);

        $apiObject = $this->event->findApiObject($event->api_id);

        return view('maintenance::events.edit', compact('event', 'apiObject'));
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
