<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Viewer\Traits\ViewableTrait;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

/**
 * Class User
 * @package Stevebauman\Maintenance\Models
 */
class User extends SentryUser
{

    use ViewableTrait;

    protected $table = 'users';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\UserViewer';

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

}