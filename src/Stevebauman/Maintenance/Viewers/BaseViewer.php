<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Viewer\AbstractViewer;

class BaseViewer extends AbstractViewer
{
    /**
     * Returns the records history view.
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        return view('maintenance::partials.history-table', ['record' => $this->entity]);
    }
}
