<?php

namespace Stevebauman\Maintenance\Traits;


trait HasNotificationsTrait
{
    /**
     * Allows all models extending from BaseModel to have notifications
     *
     * @return object
     */
    public function notifications()
    {
        return $this->morphMany('Stevebauman\Maintenance\Models\Notification', 'notifiable');
    }

}