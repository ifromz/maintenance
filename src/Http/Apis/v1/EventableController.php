<?php

namespace Stevebauman\Maintenance\Http\Apis\v1;

use Stevebauman\Maintenance\Http\Requests\Event\BetweenRequest;
use Stevebauman\Maintenance\Models\Event;
use Stevebauman\Maintenance\Repositories\EventRepository;

abstract class EventableController extends Controller
{
    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var EventRepository
     */
    protected $event;

    /**
     * @param EventRepository $event
     */
    public function __construct(EventRepository $event)
    {
        $this->event = $event->setCalendarId($this->getEventableCalendarId());
    }

    /**
     * Returns a parsed array of API event entries for FullCalendar.
     *
     * @param BetweenRequest $request
     *
     * @return array
     */
    public function between(BetweenRequest $request)
    {
        $filter = [
            'timeMin' => strToRfc3339($request->input('start')),
            'timeMax' => strToRfc3339($request->input('end')),
        ];

        return $this->event->parseEvents($this->event->getApiEvents($filter));
    }

    /**
     * Returns a new grid instance of all available events.
     *
     * @param int|string $eventableId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid($eventableId)
    {
        $columns = [
            'events.id',
            'events.user_id',
            'events.api_id',
            'events.location_id',
            'events.created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle'  => 11,
        ];

        $transformer = function (Event $event) use ($eventableId) {
            $apiObject = $this->event->findApiObject($event->api_id);

            if ($apiObject) {
                $startDate = new \DateTime($apiObject->start);
                $endDate = new \DateTime($apiObject->end);

                // If the event is all day, we'll format the dates differently.
                if ($apiObject->all_day) {
                    $start = $startDate->format('Y-m-d');
                    $end = $endDate->format('Y-m-d');
                } else {
                    $start = $startDate->format('Y-m-d h:i:s');
                    $end = $endDate->format('Y-m-d h:i:s');
                }

                return [
                    'title'    => $apiObject->title,
                    'location' => ($event->location ? $event->location->trail : null),
                    'start'    => $start,
                    'end'      => $end,
                    'view_url' => route($this->routes['show'], [$eventableId, $event->id]),
                ];
            }

            return;
        };

        return $this->getEventableRepository()->gridEvents($eventableId, $columns, $settings, $transformer);
    }

    /**
     * @return \Stevebauman\Maintenance\Repositories\Repository
     */
    abstract protected function getEventableRepository();

    /**
     * @return string
     */
    abstract protected function getEventableCalendarId();
}
