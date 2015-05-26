<?php

namespace Stevebauman\Maintenance\Viewers;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Viewer\AbstractViewer;

class NoteViewer extends AbstractViewer
{
    /**
     * Returns the noteable models actions button view.
     *
     * @param Model $noteable
     *
     * @return \Illuminate\View\View
     */
    public function btnNoteableActions(Model $noteable)
    {
        return view('maintenance::viewers.noteable.buttons.actions', [
            'noteable' => $noteable,
        ]);
    }
}
