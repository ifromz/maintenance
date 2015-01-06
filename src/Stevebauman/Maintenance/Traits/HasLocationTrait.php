<?php

namespace Stevebauman\Maintenance\Traits;

trait HasLocationTrait {
    
    public function location()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Location', 'id', 'location_id');
    }
    
}