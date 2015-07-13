<?php

namespace Stevebauman\Maintenance\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Stevebauman\Maintenance\Http\Requests\Event\MoveRequest;
use Stevebauman\Maintenance\Http\Requests\Event\ReportRequest;
use Stevebauman\Maintenance\Http\Requests\Event\Request;
use Stevebauman\CalendarHelper\Services\Google\EventService as GoogleEventService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Event;

class EventRepository extends Repository
{
    /**
     * @var LocationRepository
     */
    protected $location;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var GoogleEventService
     */
    protected $eventApi;

    /**
     * @param LocationRepository $location
     * @param SentryService      $sentry
     * @param GoogleEventService $eventApi
     */
    public function __construct(LocationRepository $location, SentryService $sentry, GoogleEventService $eventApi)
    {
        $this->location = $location;
        $this->sentry = $sentry;
        $this->eventApi = $eventApi;
    }

    /**
     * @return Event
     */
    public function model()
    {
        return new Event();
    }

    /**
     * {@inheritDoc}
     */
    public function grid(array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->model()->whereNull('parent_id');

        return parent::newGrid($model, $columns, $settings, $transformer);
    }

    /**
     * Returns all events that are not recurrences.
     *
     * @return Collection
     */
    public function getWithoutRecurrences()
    {
        return $this->model()->whereNull('parent_id')->get();
    }

    /**
     * Returns all API events that exist locally.
     *
     * @param array $filter
     *
     * @return bool|\Stevebauman\EloquentTable\TableCollection
     */
    public function getApiEvents($filter = [])
    {
        $local = $this->getWithoutRecurrences();

        if($local->count() > 0) {
            $apiIds = $local->lists('api_id')->toArray();

            return $this->eventApi->setInput($filter)->getOnly($apiIds);
        }

        return [];
    }

    /**
     * Returns the events recurrences by it's Api ID.
     *
     * @param int|string $id
     *
     * @return mixed
     */
    public function getRecurrencesByApiId($id)
    {
        $filter = [
            'timeMin' => strToRfc3339(strtotime('now')),
            'timeMax' => strToRfc3339(strtotime('+1 month')),
        ];

        return $this->eventApi->setInput($filter)->getRecurrences($id);
    }

    /**
     * Finds a google event object by it's API ID.
     *
     * @param int|string $id
     *
     * @return bool|mixed
     */
    public function findApiObject($id)
    {
        $event = $this->eventApi->find($id);

        if($event) {
            return $event;
        }

        return false;
    }

    /**
     * Creates a new event.
     *
     * @param Request $request
     *
     * @return bool|Event
     */
    public function create(Request $request)
    {
        $apiEvent = $this->eventApi->setInput($request->all())->create();

        if($apiEvent) {
            $event = $this->model();

            $event->user_id = $this->sentry->getCurrentUserId();
            $event->api_id = $apiEvent->id;

            if($request->has('location_id')) {
                $location = $this->location->model()->find($request->input('location_id'));

                if($location) {
                    $event->location_id = $request->input('location_id');
                }
            }

            if($event->save()) {
                return $event;
            }
        }

        return false;
    }

    /**
     * Creates a new report for the specified event.
     *
     * @param ReportRequest $request
     * @param int|string $id
     *
     * @return bool
     */
    public function createReport(ReportRequest $request, $id)
    {
        $event = $this->find($id);

        if($event) {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'description' => $request->clean($request->input('description')),
            ];

            $report = $event->report()->create($insert);

            if($report) {
                return $report;
            }
        }

        return false;
    }

    /**
     * Updates an event.
     *
     * @param Request    $request
     * @param int|string $id
     *
     * @return bool|Event
     */
    public function update(Request $request, $id)
    {
        $event = $this->find($id);

        if($event) {
            if($request->has('location_id')) {
                $location = $this->location->model()->find($request->input('location_id'));

                if($location) {
                    $request->location = strip_tags($location->trail);
                }
            }

            $apiEvent = $this->eventApi->setInput($request->all())->update($event->api_id);

            if($apiEvent) {
                return $event;
            }
        }

        return false;
    }

    /**
     * Deletes an event.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $event = $this->find($id);

        if($event) {
            if($this->eventApi->destroy($event->api_id)) {
                $event->delete();

                return true;
            }
        }

        return false;
    }

    /**
     * Updates the specified event dates.
     *
     * @param MoveRequest $request
     * @param int|string  $apiId
     *
     * @return mixed
     */
    public function updateDates(MoveRequest $request, $apiId)
    {
        return $this->eventApi->setInput($request->all())->updateDates($apiId);
    }

    /**
     * Parses a google collection of events into an
     * array of events compatible with FullCalendar.
     *
     * @param $events
     *
     * @return array
     */
    public function parseEvents($events)
    {
        $arrayEvents = [];

        foreach ($events as $event) {
            $startDate = new \DateTime($event->start);
            $endDate = new \DateTime($event->end);

            // Add the event into a FullCalendar compatible array
            $arrayEvents[] = [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->location,
                'start' => $startDate->format('Y-m-d H:i:s'),
                'end' => $endDate->format('Y-m-d H:i:s'),
                'allDay' => $event->all_day,
                'move' => route('maintenance.api.v1.events.move', $event->id),
                'token' => csrf_token(),
            ];
        }

        return $arrayEvents;
    }

    /**
     * Sets the calendar ID for the current event API.
     *
     * @param string $id
     *
     * @return $this
     */
    public function setCalendarId($id)
    {
        $this->eventApi->setCalendar($id);

        return $this;
    }
}
