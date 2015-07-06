<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

use Stevebauman\Maintenance\Models\Location;

trait HasLocationTrait
{
    /**
     * The hasOne location relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    /**
     * Filters inventory results by specified location.
     *
     * @param mixed      $query
     * @param int|string $locationId
     *
     * @return mixed
     */
    public function scopeLocation($query, $locationId = null)
    {
        if (!is_null($locationId)) {
            // Get descendants and self inventory category nodes
            $locations = Location::find($locationId)->getDescendantsAndSelf();

            // Perform a sub-query on main query
            $query->where(function ($query) use ($locations) {
                // For each category, apply a orWhere query to the sub-query
                foreach ($locations as $location) {
                    $query->orWhere('location_id', $location->id);
                }
            });
        }

        return $query;
    }
}
