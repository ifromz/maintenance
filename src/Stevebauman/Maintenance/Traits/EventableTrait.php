<?php

namespace Stevebauman\Maintenance\Traits;

trait EventableTrait {
    
    public function events()
    {
        return $this->morphToMany('Stevebauman\Maintenance\Models\Event', 'eventable');
    }
    
}