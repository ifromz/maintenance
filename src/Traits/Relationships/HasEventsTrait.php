<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

use Stevebauman\Maintenance\Models\Event;

trait HasEventsTrait
{
    /**
     * The morphToMany events relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function events()
    {
        return $this->morphToMany(Event::class, 'eventable')->withTimestamps();
    }
}
