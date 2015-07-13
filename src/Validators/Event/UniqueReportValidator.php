<?php

namespace Stevebauman\Maintenance\Validators\Event;

use Illuminate\Support\Facades\Route;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Services\Event\ReportService;

class UniqueReportValidator
{
    /**
     * @var EventService
     */
    protected $event;

    /**
     * @var ReportService
     */
    protected $report;

    /**
     * Constructor.
     *
     * @param EventService  $event
     * @param ReportService $report
     */
    public function __construct(EventService $event, ReportService $report)
    {
        $this->event = $event;
        $this->report = $report;
    }

    /**
     * Validates that the event only has one report.
     *
     * @param string $attribute
     * @param string $value
     * @param $parameters
     *
     * @return bool
     */
    public function validateUniqueReport($attribute, $value, $parameters)
    {
        if (is_array($parameters) && count($parameters) > 0) {
            $eventId = Route::getCurrentRoute()->getParameter('events');

            // Make sure the event exists
            $event = $this->event->find($eventId);

            if ($event) {
                $report = $this->report->where('event_id', $parameters[0])->first();

                if ($report) {
                    return false;
                }

                return true;
            }
        }

        return false;
    }
}
