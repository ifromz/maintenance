<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Viewer\AbstractViewer;

class BaseViewer extends AbstractViewer {
    
    /*
     * Allows all child viewers to display their records history
     */
    public function history()
    {
        return view('maintenance::partials.history-table', ['record'=>$this->entity]);
    }
    
}