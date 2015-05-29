<?php

namespace Stevebauman\Maintenance\Http\Apis\v1;

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
                    'view_url' => route('maintenance.events.show', [$element->id]),
                ];
            }

            return null;
        };

        return $this->event->grid($columns, $settings, $transformer);
    }
}
