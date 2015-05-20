<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

trait HasEventsTrait
{
    /**
     * The morphToMany events relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function events()
    {
        return $this->morphToMany('Stevebauman\Maintenance\Models\Event', 'eventable')->withTimestamps();
    }
}
