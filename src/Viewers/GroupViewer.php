<?php

namespace Stevebauman\Maintenance\Viewers;

class GroupViewer extends BaseViewer
{
    /**
     * Returns the groups profile view.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('maintenance::viewers.group.profile', ['group' => $this->entity]);
    }

    /**
     * Returns the groups users view.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        return view('maintenance::viewers.group.users', ['group' => $this->entity]);
    }

    /**
     * Returns the groups permissions view.
     *
     * @return \Illuminate\View\View
     */
    public function permissions()
    {
        return view('maintenance::viewers.group.permissions', ['group' => $this->entity]);
    }

    /**
     * Returns the groups action buttons view.
     *
     * @return \Illuminate\View\View
     */
    public function btnActions()
    {
        return view('maintenance::viewers.group.buttons.actions', ['group' => $this->entity]);
    }

    /**
     * Returns the groups edit button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnEdit()
    {
        return view('maintenance::viewers.group.buttons.edit', ['group' => $this->entity]);
    }

    /**
     * Returns the groups delete button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnDelete()
    {
        return view('maintenance::viewers.group.buttons.delete', ['group' => $this->entity]);
    }
}
