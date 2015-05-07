<?php

namespace Stevebauman\Maintenance\Listeners;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Maintenance\Models\Notification;

/**
 * Class AbstractListener.
 */
abstract class AbstractListener
{
    /**
     * Creates a notification.
     *
     * @param string $user_id
     * @param Model  $model
     * @param string $message
     * @param string $link
     * @param string $link
     * @param null   $before
     * @param null   $after
     */
    public function createNotification($user_id, Model $model, $message, $link, $before = null, $after = null)
    {
        $notification = Notification::create([
            'user_id' => $user_id,
            'notifiable_type' => get_class($model),
            'notifiable_id' => $model->id,
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
