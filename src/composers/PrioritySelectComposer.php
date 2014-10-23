<?php 

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\PriorityService;

class PrioritySelectComposer {
    
    public function __construct(PriorityService $priority)
    {
        $this->priority = $priority;
    }
    
    public function compose($view)
    {
        $priorities = $this->priority->get()->lists('name', 'id');
        
        /*
         * Default selected None value
         */
        $priorities[NULL] = 'None';
        
        return $view->with('priorities', $priorities);
    }
    
}
