<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Viewer\AbstractViewer;

class NoteViewer extends AbstractViewer
{
    public function btnNoteableActions($noteable)
    {
        return view('maintenance::viewers.');
    }
}
