<?php

namespace Stevebauman\Maintenance\Models;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Traits\HasUserTrait;

/**
 * Class Notification
 *
 * @package Stevebauman\Maintenance\Models
 */
class Notification extends BaseModel
{
    use HasUserTrait;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'notifiable_id',
        'notifiable_type',
        'message',
        'link',
        'read'
    ];

    /**
     * The morphTo relationship allowing all models to have notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    /**
     * Returns an html icon of the type of notification.
     *
     * @return string|null
     */
    public function getIconAttribute()
    {
        $class = $this->attributes['notifiable_type'];

        /*
         * Resolve the configuration service from the IoC
         */
        $config = App::make('Stevebauman\Maintenance\Services\ConfigService');

        if ($icon = $config->setPrefix('maintenance')->get("notifications.icons.$class")) return $icon;

        //@todo Return default icon class
        return null;
    }
}
