<?php

namespace Stevebauman\Maintenance\Http\Apis\v1;

use Stevebauman\Maintenance\Http\Requests\Event\BetweenRequest;
use Stevebauman\Maintenance\Http\Requests\Event\MoveRequest;
use Stevebauman\Maintenance\Repositories\EventRepository;

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
     * Moves the specified event from one time to another.
     *
     * @param MoveRequest $request
     * @param int|string  $apiId
     *
     * @return array
     */
    public function move(MoveRequest $request, $apiId)
    {
        if($this->event->updateDates($request, $apiId)) {
            $message = 'Successfully updated event.';
            $messageType = 'success';
        } else {
            $message = 'There was an issue updating this event. Please try again.';
            $messageType = 'danger';
        }

        return [
            'message' => $message,
            'messageType' => $messageType,
        ];
    }

    /**
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'user_id',
            'api_id',
            'location_id',
            'created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
        ];

        $transformer = function($element)
        {
            $apiObject = $this->event->findApiObject($element->api_id);

            if($apiObject) {
                $startDate = new \DateTime($apiObject->start);
                $endDate = new \DateTime($apiObject->end);

                return [
                    'title' => $apiObject->title,
                    'location' => ($element->location ? $element->location->trail : null),
                    'start' => $startDate->format('Y-m-d h:i:s'),
                    'end' => $endDate->format('Y-m-d h:i:s'),
                    'view' => route('maintenance.events.show', [$element->id]),
                ];
            }

            return null;
        };

        return $this->event->grid($columns, $settings, $transformer);
    }

    /**
     * Returns the specified events recurrences.
     *
     * @param int|string $id
     *
     * @return array|\Cartalyst\DataGrid\DataGrid
     */
    public function gridRecurrences($id)
    {
        $events = $this->event->getRecurrencesByApiId($id);

        if($events) {
            $columns = [
                'start',
                'end',
            ];

            $settings = [
                'sort'      => 'start',
                'direction' => 'desc',
            ];

            return $this->event->newGrid($events, $columns, $settings);
        }

        return [];
    }
}
