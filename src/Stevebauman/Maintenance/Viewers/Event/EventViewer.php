<?php

namespace Stevebauman\Maintenance\Viewers\Event;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class EventViewer extends BaseViewer
{
    /**
     * Returns the events tags view.
     *
     * @return \Illuminate\View\View
     */
    public function tags()
    {
        /*
         * Make sure we pass in the parent event if this event is a recurrence
         * so we can use it's tags
         */
        if ($this->entity->parentEvent) {
            $event = $this->entity->parentEvent;
        } else {
            $event = $this->entity;
        }

        return view('maintenance::viewers.event.tags', [
            'event' => $event,
        ]);
    }

    /**
     * Returns the events report view.
     *
     * @return \Illuminate\View\View
     */
    public function report()
    {
        return view('maintenance::viewers.event.report', [
            'event' => $this->entity,
        ]);
    }

    /**
     * Returns the events report created label view.
     *
     * @return \Illuminate\View\View
     */
    public function lblReportCreated()
    {
        return view('maintenance::viewers.event.labels.report-created', [
            'event' => $this->entity,
        ]);
    }
}
