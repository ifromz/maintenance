<?php

namespace Stevebauman\Maintenance\Viewers;

class WorkOrderViewer extends BaseViewer
{
    public function profile()
    {
        return view('maintenance::viewers.work-order.profile', ['workOrder' => $this->entity]);
    }

    public function workRequest()
    {
        return view('maintenance::viewers.work-order.work-request', ['workOrder' => $this->entity]);
    }

    public function calendar()
    {
        return view('maintenance::viewers.work-order.calendar', ['workOrder' => $this->entity]);
    }

    public function report()
    {
        return view('maintenance::viewers.work-order.report', ['workOrder' => $this->entity]);
    }

    public function sessions()
    {
        return view('maintenance::viewers.work-order.sessions', ['workOrder' => $this->entity]);
    }

    public function attachments()
    {
        return view('maintenance::viewers.work-order.attachments', ['workOrder' => $this->entity]);
    }

    public function parts()
    {
        return view('maintenance::viewers.work-order.parts', ['workOrder' => $this->entity]);
    }

    public function updates()
    {
        return view('maintenance::viewers.work-order.updates', ['workOrder' => $this->entity]);
    }

    public function startedAtFormatted()
    {
        if ($this->entity->started_at) {
            $date = new \DateTime();

            $date->setTimestamp(strtotime($this->entity->started_at));

            return $date->format('M dS Y - h:ia');
        }
    }

    public function completedAtFormatted()
    {
        if ($this->entity->completed_at) {
            $date = new \DateTime();

            $date->setTimestamp(strtotime($this->entity->completed_at));

            return $date->format('M dS Y - h:ia');
        }
    }

    public function btnEdit()
    {
        return view('maintenance::viewers.work-order.buttons.edit', ['workOrder' => $this->entity]);
    }

    public function btnDelete()
    {
        return view('maintenance::viewers.work-order.buttons.delete', ['workOrder' => $this->entity]);
    }

    public function btnDeleteArchive()
    {
        return view('maintenance::viewers.work-order.buttons.delete-archive', ['workOrder' => $this->entity]);
    }

    public function btnEvents()
    {
        return view('maintenance::viewers.work-order.buttons.events', ['workOrder' => $this->entity]);
    }

    public function btnCheckIn()
    {
        return view('maintenance::viewers.work-order.buttons.check-in', ['workOrder' => $this->entity]);
    }

    public function btnWorkers()
    {
        return view('maintenance::viewers.work-order.buttons.workers', ['workOrder' => $this->entity]);
    }

    public function btnNotifications()
    {
        return view('maintenance::viewers.work-order.buttons.notifications', ['workOrder' => $this->entity]);
    }

    public function btnComplete()
    {
        return view('maintenance::viewers.work-order.buttons.complete', ['workOrder' => $this->entity]);
    }

    public function btnAddParts()
    {
        return view('maintenance::viewers.work-order.buttons.add-parts', ['workOrder' => $this->entity]);
    }

    public function btnAddAttachments()
    {
        return view('maintenance::viewers.work-order.buttons.add-attachments', ['workOrder' => $this->entity]);
    }

    public function btnEventTag()
    {
        return view('maintenance::viewers.work-order.buttons.event-tag', [
            'workOrder' => $this->entity,
        ]);
    }

    public function btnRestore()
    {
        return view('maintenance::viewers.work-order.buttons.restore', ['workOrder' => $this->entity]);
    }

    public function btnActions()
    {
        return view('maintenance::viewers.work-order.buttons.actions', ['workOrder' => $this->entity]);
    }

    public function btnActionsArchive()
    {
        return view('maintenance::viewers.work-order.buttons.actions-archive', ['workOrder' => $this->entity]);
    }

    public function lblStartedAt()
    {
        return view('maintenance::viewers.work-order.labels.started-at', ['workOrder' => $this->entity]);
    }

    public function lblCompletedAt()
    {
        return view('maintenance::viewers.work-order.labels.completed-at', ['workOrder' => $this->entity]);
    }

    public function lblCheckCompleted()
    {
        return view('maintenance::viewers.work-order.labels.check-completed', ['workOrder' => $this->entity]);
    }
}
