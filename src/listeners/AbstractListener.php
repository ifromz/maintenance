<?php

namespace Stevebauman\Maintenance\Listeners;

use Stevebauman\Maintenance\Models\Notification;

abstract class AbstractListener {
    
    public function createNotification($object, $message, $link, $before = NULL, $after = NULL)
    {
        return Notification::create(array(
            'notifiable_type' => get_class($object),
            'notifiable_id' => $object->id,
            'message' => $message,
            'link' => $link,
            'before' => $before,
            'after' => $after,
        ));
    }
    
}