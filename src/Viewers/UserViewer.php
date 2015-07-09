<?php

namespace Stevebauman\Maintenance\Viewers;

class UserViewer extends BaseViewer
{
    /**
     * Returns the users profile view.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('maintenance::viewers.user.profile', [
            'user' => $this->entity,
        ]);
    }

    /**
     * Returns the users permissions checker form view.
     *
     * @return \Illuminate\View\View
     */
    public function permissionChecker()
    {
        return view('maintenance::viewers.user.permission-checker', [
            'user' => $this->entity,
        ]);
    }

    /**
     * Returns the users edit button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnEdit()
    {
        return view('maintenance::viewers.user.buttons.edit', [
            'user' => $this->entity,
        ]);
    }

    /**
     * Returns the users delete button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnDelete()
    {
        return view('maintenance::viewers.user.buttons.delete', [
            'user' => $this->entity,
        ]);
    }

    /**
     * Returns the users update password button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnUpdatePassword()
    {
        return view('maintenance::viewers.user.buttons.update-password', [
            'user' => $this->entity,
        ]);
    }

    /**
     * Returns the users action buttons view.
     *
     * @return \Illuminate\View\View
     */
    public function btnActions()
    {
        return view('maintenance::viewers.user.buttons.actions', [
            'user' => $this->entity,
        ]);
    }
}
