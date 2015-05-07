<?php

namespace Stevebauman\Maintenance\Traits;

trait HasEventsTrait
{
    public function events()
    {
        return $this->morphToMany('Stevebauman\Maintenance\Models\Event', 'eventable')->withTimestamps();
    }
}
