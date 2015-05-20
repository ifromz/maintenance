<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

trait HasNotificationsTrait
{
    /**
     * Allows all models extending from BaseModel to have notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany('Stevebauman\Maintenance\Models\Notification', 'notifiable');
    }
}
