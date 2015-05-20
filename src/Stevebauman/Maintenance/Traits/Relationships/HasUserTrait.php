<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

/**
 * Trait HasUserTrait.
 */
trait HasUserTrait
{
    /**
     * The hasOne user trait.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
    }
}
