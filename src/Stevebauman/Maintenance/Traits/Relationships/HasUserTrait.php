<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

use Stevebauman\Maintenance\Models\User;

trait HasUserTrait
{
    /**
     * The hasOne user trait.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
