<?php

namespace Stevebauman\Maintenance\Traits;

use Stevebauman\Maintenance\Traits\HasScopeLocationTrait;

trait HasLocationTrait {

    use HasScopeLocationTrait;

    public function location()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Location', 'id', 'location_id');
    }
    
}