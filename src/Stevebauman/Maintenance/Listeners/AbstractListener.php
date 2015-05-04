<?php

namespace Stevebauman\Maintenance\Listeners;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Stevebauman\Maintenance\Models\Notification;

/**
 * Class AbstractListener
 * @package Stevebauman\Maintenance\Listeners
 */
abstract class AbstractListener
{

    /**
     * @param string $user_id
     * @param object $object
     * @param string $message
     * @param string $link
     * @param string $link
     * @param null $before
     * @param null $after
     */
    public function createNotification($user_id, $object, $message, $link, $before = null, $after = null)
    {
        $notification = Notification::create([
            'user_id' => $user_id,
            'notifiable_type' => get_class($object),
            'notifiable_id' => $object->id,
            'message' => $message,
            'link' => $link,
            'before' => $before,
            'after' => $after,
        ]);

        Mail::send('maintenance::emails.notification', ['notification' => $notification], function (Message $message) {
            $message->to('sbauman@bwbc.gc.ca')->subject('Testing');
        });

    }

}