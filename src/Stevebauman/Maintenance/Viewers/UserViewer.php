<?php

namespace Stevebauman\Maintenance\Viewers;

/**
 * Class UserViewer
 * @package Stevebauman\Maintenance\Viewers
 */
class UserViewer extends BaseViewer
{
    public function profile()
    {
        return view('maintenance::viewers.user.profile', [
            'user' => $this->entity,
        ]);
    }

    public function permissionChecker()
    {
        return view('maintenance::viewers.user.permission-checker', [
            'user' => $this->entity,
        ]);
    }

    public function btnEdit()
    {
        return view('maintenance::viewers.user.buttons.edit', [
            'user' => $this->entity,
        ]);
    }

    public function btnDelete()
    {
        return view('maintenance::viewers.user.buttons.delete', [
            'user' => $this->entity,
        ]);
    }

    public function btnUpdatePassword()
    {
        return view('maintenance::viewers.user.buttons.update-password', [
            'user' => $this->entity,
        ]);
    }

    public function btnActions()
    {
        return view('maintenance::viewers.user.buttons.actions', [
            'user' => $this->entity,
        ]);
    }

}