<?php

namespace Stevebauman\Maintenance\Apis\v1;

use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Apis\v1\BaseApi;

class AbstractEventableApi extends BaseApi
{

    /*
     * Holds Eventable Service
     */
    protected $eventable;

    /*
     * Holds Event Service
     */
    protected $event;

    public function __construct(EventService $event)
    {
        $this->event = $event;
    }

    public function show($eventable_id)
    {
        $eventable = $this->eventable->find($eventable_id);

        $data = array(
            'timeMin' => strToRfc3339($this->input('start')),
            'timeMax' => strToRfc3339($this->input('end')),
        );

        $events = $eventable->events->lists('api_id');

        $apiEvents = $this->event->setInput($data)->getApiEvents($events, true);

        return $this->responseJson($this->event->parseEvents($apiEvents));
    }

}