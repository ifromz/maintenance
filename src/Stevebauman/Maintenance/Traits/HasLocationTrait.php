<?php

namespace Stevebauman\Maintenance\Traits;

trait HasLocationTrait {

    public function location()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Location', 'id', 'location_id');
    }

    /**
     * Filters inventory results by specified location
     *
     * @return object
     */
    public function scopeLocation($query, $location_id = NULL)
    {
        if ($location_id) {
            /*
             * Get descendants and self inventory category nodes
             */
            $locations = Location::find($location_id)->getDescendantsAndSelf();
            /*
             * Perform a subquery on main query
             */
            $query->where(function ($query) use ($locations) {
                /*
                 * For each category, apply a orWhere query to the subquery
                 */
                foreach ($locations as $location) {
                    $query->orWhere('location_id', $location->id);
                }
                return $query;
            });
        }
    }


}