<?php

namespace Stevebauman\Maintenance\Traits;

trait HasUserTrait
{
    /**
     * The has one user trait
     *
     * @return mixed
     */
    public function user()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
    }
    
}