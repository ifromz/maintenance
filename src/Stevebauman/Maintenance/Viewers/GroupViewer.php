<?php

namespace Stevebauman\Maintenance\Viewers;

/**
 * Class GroupViewer.
 */
class GroupViewer extends BaseViewer
{
    public function profile()
    {
        return view('maintenance::viewers.group.profile', ['group' => $this->entity]);
    }

    public function users()
    {
        return view('maintenance::viewers.group.users', ['group' => $this->entity]);
    }

    public function permissions()
    {
        return view('maintenance::viewers.group.permissions', ['group' => $this->entity]);
    }

    public function btnActions()
    {
        return view('maintenance::viewers.group.buttons.actions', ['group' => $this->entity]);
    }

    public function btnEdit()
    {
        return view('maintenance::viewers.group.buttons.edit', ['group' => $this->entity]);
    }

    public function btnDelete()
    {
        return view('maintenance::viewers.group.buttons.delete', ['group' => $this->entity]);
    }
}
