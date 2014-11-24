<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Viewer\AbstractViewer;

class BaseViewer extends AbstractViewer {
    
    public function history()
    {
        return view('maintenance::partials.history-table', array('record'=>$this->entity));
    }
    
}