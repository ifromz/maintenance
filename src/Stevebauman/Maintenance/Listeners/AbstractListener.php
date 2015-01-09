<?php

namespace Stevebauman\Maintenance\Listeners;

use Illuminate\Support\Facades\Mail;
use Stevebauman\Maintenance\Models\Notification;

abstract class AbstractListener
{

    public function createNotification($user_id, $object, $message, $link, $before = NULL, $after = NULL)
    {
        $notification = Notification::create(array(
            'user_id' => $user_id,
            'notifiable_type' => get_class($object),
            'notifiable_id' => $object->id,
            'message' => $message,
            'link' => $link,
            'before' => $before,
            'after' => $after,
        ));

        Mail::send('maintenance::emails.notification', array('notification' => $notification), function ($message) {
            $message->to('sbauman@bwbc.gc.ca')->subject('Testing');
        });

    }

    private function getNotifiableUsers($id)
    {
        
    }

}