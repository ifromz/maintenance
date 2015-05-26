<?php

namespace Stevebauman\Maintenance\Viewers\Event;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\EloquentTable\TableCollection;
use Stevebauman\Maintenance\Viewers\BaseViewer;

class ApiEventViewer extends BaseViewer
{
    /**
     * Returns the API events profile view.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('maintenance::viewers.event.profile', [
            'event' => $this->entity,
        ]);
    }

    /**
     * Returns the API events recurrences
     * view with the specified recurrences.
     *
     * @param TableCollection $recurrences
     *
     * @return \Illuminate\View\View
     */
    public function recurrences(TableCollection $recurrences)
    {
        return view('maintenance::viewers.event.recurrences', [
            'event' => $this->entity,
            'recurrences' => $recurrences,
        ]);
    }

    /**
     * Returns the API events attendees view.
     *
     * @return \Illuminate\View\View
     */
    public function attendees()
    {
        return view('maintenance::viewers.event.attendees', [
            'event' => $this->entity,
        ]);
    }

    /**
     * Returns the API events recurrence warning view.
     *
     * @return \Illuminate\View\View
     */
    public function recurrenceWarning()
    {
        return view('maintenance::viewers.event.recurrence-warning', [
            'event' => $this->entity,
        ]);
    }

    /**
     * Presents the correct date timestamp depending if the event is all day.
     *
     * @return string
     */
    public function startFormatted()
    {
        $start = new \DateTime();

        $start->setTimestamp(strtotime($this->entity->start));

        if ($this->entity->all_day) {
            return $start->format('M dS Y');
        } else {
            return $start->format('M dS Y - h:ia');
        }
    }

    /**
     * Presents the correct start date formatted for editing.
     *
     * @return string
     */
    public function startDateFormatted()
    {
        $start = new \DateTime();

        $start->setTimestamp(strtotime($this->entity->start));

        return $start->format('m/d/Y');
    }

    /**
     * Presents the correct start time formatted for editing.
     *
     * @return string|null
     */
    public function startTimeFormatted()
    {
        if (!$this->entity->all_day) {
            $start = new \DateTime();

            $start->setTimestamp(strtotime($this->entity->start));

            return $start->format('H:i A');
        }

        return null;
    }

    /**
     * Presents the correct date timestamp depending if the event is all day.
     *
     * @return string
     */
    public function endFormatted()
    {
        $end = new \DateTime();

        $end->setTimestamp(strtotime($this->entity->end));

        if ($this->entity->all_day) {
            return $end->format('M dS Y');
        }

        return $end->format('M dS Y - h:ia');
    }

    /**
     * Presents the correct end date formatted for editing.
     *
     * @return string
     */
    public function endDateFormatted()
    {
        $end = new \DateTime();

        $end->setTimestamp(strtotime($this->entity->start));

        return $end->format('m/d/Y');
    }

    /**
     * Presents the correct end time formatted for editing.
     *
     * @return string|null
     */
    public function endTimeFormatted()
    {
        if (!$this->entity->all_day) {
            $end = new \DateTime();

            $end->setTimestamp(strtotime($this->entity->start));

            return $end->format('H:i A');
        }

        return null;
    }

    /**
     * Presents the API events recurrence frequency in a nicer format.
     *
     * @return string
     */
    public function recurFrequencyFormatted()
    {
        if ($this->recurFrequency()) {
            return ucfirst(strtolower($this->recurFrequency()));
        }

        return 'None';
    }

    /**
     * Returns the API events actual recurrence frequency array.
     *
     * @return array|null
     */
    public function recurFrequency()
    {
        if ($this->entity->rruleArray && array_key_exists('FREQ', $this->entity->rruleArray)) {
            $freq = $this->entity->rruleArray['FREQ'];

            return $freq;
        }

        return null;
    }

    /**
     * Returns the API events actual recurring days array.
     *
     * @return array|null
     */
    public function recurDays()
    {
        if ($this->entity->rruleArray && array_key_exists('BYDAY', $this->entity->rruleArray)) {
            $freq = $this->entity->rruleArray['BYDAY'];

            return $freq;
        }

        return null;
    }

    /**
     * Returns the API events recurring label view.
     *
     * @return \Illuminate\View\View
     */
    public function lblRecurring()
    {
        return view('maintenance::viewers.event.labels.recurring', ['event' => $this->entity]);
    }

    /**
     * Returns the API events all day label view.
     *
     * @return \Illuminate\View\View
     */
    public function lblAllDay()
    {
        return view('maintenance::viewers.event.labels.all-day', ['event' => $this->entity]);
    }

    /**
     * Returns events actions button view
     * for the specified eventable model.
     *
     * @param Model $eventable
     *
     * @return \Illuminate\View\View
     */
    public function btnEventableActions(Model $eventable)
    {
        return view('maintenance::viewers.event.buttons.eventable-actions', [
            'event' => $this->entity,
            'eventable' => $eventable,
        ]);
    }

    /**
     * Returns events edit button view
     * for the specified eventable model.
     *
     * @param Model $eventable
     *
     * @return \Illuminate\View\View
     */
    public function btnEventableEdit(Model $eventable)
    {
        return view('maintenance::viewers.event.buttons.eventable-edit', [
            'event' => $this->entity,
            'eventable' => $eventable,
        ]);
    }

    /**
     * Returns events actions delete button view
     * for the specified eventable model.
     *
     * @param Model $eventable
     *
     * @return \Illuminate\View\View
     */
    public function btnEventableDelete(Model $eventable)
    {
        return view('maintenance::viewers.event.buttons.eventable-delete', [
            'event' => $this->entity,
            'eventable' => $eventable,
        ]);
    }

    /**
     * Returns the events edit button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnEdit()
    {
        return view('maintenance::viewers.event.buttons.edit', ['event' => $this->entity]);
    }

    /**
     * Returns the events delete button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnDelete()
    {
        return view('maintenance::viewers.event.buttons.delete', ['event' => $this->entity]);
    }

    /**
     * Returns the events action buttons view.
     *
     * @return \Illuminate\View\View
     */
    public function btnActions()
    {
        return view('maintenance::viewers.event.buttons.actions', ['event' => $this->entity]);
    }
}
