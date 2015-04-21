<?php

namespace Stevebauman\Maintenance\Traits;

/**
 * Trait HasUserTrait
 * @package Stevebauman\Maintenance\Traits
 */
trait HasUserTrait
{
    /**
     * The has one user trait
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
    }
}