<?php

namespace Stevebauman\Maintenance\Viewers\Event;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class ApiEventViewer extends BaseViewer {
    
    /**
     * Returns a view of the profile of the event
     * 
     * @return view
     */
    public function profile()
    {
        return view('maintenance::viewers.event.profile', [
            'event' => $this->entity,
        ]);
    }
    
    public function recurrences($recurrences)
    {
        return view('maintenance::viewers.event.recurrences', [
            'event' => $this->entity,
            'recurrences' => $recurrences
        ]);
    }
    
    public function attendees()
    {
        return view('maintenance::viewers.event.attendees', [
            'event' => $this->entity
        ]);
    }
    
    public function recurrenceWarning()
    {
        return view('maintenance::viewers.event.recurrence-warning', [
            'event' => $this->entity
        ]);
    }
    
    /**
     * Presents the correct date timestamp depending if the event is all day
     * 
     * @return string
     */
    public function startFormatted()
    {
        $start = new \DateTime();
        
        $start->setTimestamp(strtotime($this->entity->start));
        
        if($this->entity->all_day) {
            return $start->format('M dS Y'); 
        } else {
            return $start->format('M dS Y - h:ia'); 
        }
    }
    
    /**
     * Presents the correct start date formatted for editing
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
     * Presents the correct start time formatted for editing
     * 
     * @return type
     */
    public function startTimeFormatted()
    {
        if(!$this->entity->all_day) {
            $start = new \DateTime();
        
            $start->setTimestamp(strtotime($this->entity->start));

            return $start->format('H:i A'); 
        }
    }
    
    /**
     * Presents the correct date timestamp depending if the event is all day
     * 
     * @return string
     */
    public function endFormatted()
    {
        $end = new \DateTime();
        
        $end->setTimestamp(strtotime($this->entity->end));
        
        if($this->entity->all_day) {
            return $end->format('M dS Y'); 
        } else {
            return $end->format('M dS Y - h:ia'); 
        }
    }
    
    /**
     * Presents the correct end date formatted for editing
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
     * Presents the correct end time formatted for editing
     * 
     * @return string
     */
    public function endTimeFormatted()
    {
        if(!$this->entity->all_day) {
            $end = new \DateTime();
            
            $end->setTimestamp(strtotime($this->entity->start));

            return $end->format('H:i A'); 
        }
    }
    
    public function recurFrequencyFormatted()
    {
        if($this->recurFrequency()) {
            return ucfirst(strtolower($this->recurFrequency()));
        } else {
            return 'None';
        }
    }
    
    public function recurFrequency()
    {
        if($this->entity->rruleArray && array_key_exists('FREQ', $this->entity->rruleArray)) {
            
            $freq = $this->entity->rruleArray['FREQ'];
            
            return $freq;
        }
    }
    
    public function recurDays()
    {
        if($this->entity->rruleArray && array_key_exists('BYDAY', $this->entity->rruleArray)) {
            
            $freq = $this->entity->rruleArray['BYDAY'];
            
            return $freq;
        }
    }
    
    public function lblRecurring()
    {
        return view('maintenance::viewers.event.labels.recurring', ['event'=>$this->entity]);
    }
    
    /**
     * Returns a view of the all day label
     * 
     * @return type
     */
    public function lblAllDay()
    {
        return view('maintenance::viewers.event.labels.all-day', ['event'=>$this->entity]);
    }

    public function btnEventableActions($eventable)
    {
        return view('maintenance::viewers.event.buttons.eventable-actions', [
            'event'=>$this->entity,
            'eventable' => $eventable,
        ]);
    }

    public function btnEventableEdit($eventable)
    {
        return view('maintenance::viewers.event.buttons.eventable-edit', [
            'event' => $this->entity,
            'eventable' => $eventable,
        ]);
    }

    public function btnEventableDelete($eventable)
    {
        return view('maintenance::viewers.event.buttons.eventable-delete', [
            'event' => $this->entity,
            'eventable' => $eventable,
        ]);
    }

    public function btnActions()
    {
        return view('maintenance::viewers.event.buttons.actions', ['event'=>$this->entity]);
    }
    
    public function btnEdit()
    {
        return view('maintenance::viewers.event.buttons.edit', ['event' => $this->entity]);
    }
    
    public function btnDelete()
    {
        return view('maintenance::viewers.event.buttons.delete', ['event' => $this->entity]);
    }
    
}