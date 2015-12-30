<?php

namespace Stevebauman\Maintenance\Http\Controllers\Event;

use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;
use Stevebauman\Maintenance\Http\Requests\Event\ReportRequest;
use Stevebauman\Maintenance\Repositories\EventRepository;

class ReportController extends BaseController
{
    /**
     * @var EventRepository
     */
    protected $event;

    /**
     * Constructor.
     *
     * @param EventRepository $event
     */
    public function __construct(EventRepository $event)
    {
        $this->event = $event;
    }

    /**
     * Creates a new report on the specified event.
     *
     * @param ReportRequest $request
     * @param int|string    $eventId
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(ReportRequest $request, $eventId)
    {
        $report = $this->event->createReport($request, $eventId);

        if ($report) {
            $message = 'Successfully created event report.';

            return redirect()->route('maintenance.events.show', [$eventId, '#tab-report'])->withSuccess($message);
        } else {
            $message = 'There was an issue creating a report for this event. Please try again.';

            return redirect()->route('maintenance.events.show', [$eventId, '#tab-report'])->withErrors($message);
        }
    }

    public function edit($event_id, $report_id)
    {
    }

    public function update($event_id, $report_id)
    {
    }

    public function destroy($event_id, $report_id)
    {
    }
}
