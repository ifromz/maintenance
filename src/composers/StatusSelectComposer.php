<?php 

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\StatusService;

class StatusSelectComposer {
    
    public function __construct(StatusService $status)
    {
        $this->status = $status;
    }
    
    public function compose($view)
    {
        $statuses = $this->status->get()->lists('name', 'id');
        
        /*
         * Default selected None value
         */
        $statuses[NULL] = 'Select a Status';
        
        return $view->with('statuses', $statuses);
    }
    
}
