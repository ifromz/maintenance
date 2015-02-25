<?php

namespace Stevebauman\Maintenance\Viewers;

/**
 * Class GroupViewer
 * @package Stevebauman\Maintenance\Viewers
 */
class GroupViewer extends BaseViewer
{
    public function profile()
    {
        return view('maintenance::viewers.group.profile', array('group'=>$this->entity));
    }

    public function users()
    {
        return view('maintenance::viewers.group.users', array('group'=>$this->entity));
    }

    public function permissions()
    {
        return view('maintenance::viewers.group.permissions', array('group'=>$this->entity));
    }

    public function btnActions()
    {
        return view('maintenance::viewers.group.buttons.actions', array('group'=>$this->entity));
    }

    public function btnEdit()
    {
        return view('maintenance::viewers.group.buttons.edit', array('group'=>$this->entity));
    }

    public function btnDelete()
    {
        return view('maintenance::viewers.group.buttons.delete', array('group'=>$this->entity));
    }
}