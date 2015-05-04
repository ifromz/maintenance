<?php

namespace Stevebauman\Maintenance\Traits;

trait HasScopeIdTrait
{
    /**
     * Allows all tables extending from the base model to be scoped by ID
     *
     * @param object $query
     * @param integer /string $id
     * @return object
     */
    public function scopeId($query, $id = null)
    {
        if ($id) {
            return $query->where('id', $id);
        }
    }

}