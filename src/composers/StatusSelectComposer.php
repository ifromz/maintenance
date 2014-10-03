<?php namespace Stevebauman\Maintenance\Http\Composers;

use Illuminate\Support\Facades\Config;

class StatusSelectComposer {
    
    public function compose($view){
        $statuses = Config::get('maintenance::status.options');
        
        return $view->with('statuses', $statuses);
    }
    
}
