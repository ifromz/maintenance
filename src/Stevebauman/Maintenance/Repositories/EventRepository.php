<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Http\Requests\Event\Request;
use Stevebauman\CalendarHelper\Services\Google\EventService as GoogleEventService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Repositories\LocationRepository;
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
        $input = $request->all();

        if(array_key_exists('location_id', $input)) {

            $location = $this->location->find($input['location_id']);

            if($location) {
                $input['location'] = strip_tags($location->trail);
            }
        }

        $apiEvent = $this->eventApi->setInput($request->all())->create();

        if($apiEvent) {
            $event = $this->model();

            $event->user_id = $this->sentry->getCurrentUserId();
            $event->location_id = $request->input('location_id', null);
            $event->api_id = $apiEvent->id;

            if($event->save()) {
                return $event;
            }
        }

        return false;
    }

    public function update(Request $request, $id)
    {

    }
}
