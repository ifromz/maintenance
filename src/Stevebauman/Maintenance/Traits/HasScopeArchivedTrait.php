<?php

namespace Stevebauman\Maintenance\Traits;

trait HasScopeArchivedTrait {

    /**
     * Scopes a query to show only soft deleted records
     *
     * @param object $query
     * @param boolean $archived
     * @return object
     */
    public function scopeArchived($query, $archived = false)
    {
        if ($archived) {
            return $query->onlyTrashed();
        }
    }

}