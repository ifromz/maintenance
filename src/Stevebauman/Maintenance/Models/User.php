<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Scopes\HasScopeIdTrait;
use Stevebauman\EloquentTable\TableTrait;
use Stevebauman\Viewer\Traits\ViewableTrait;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

/**
 * Class User.
 */
class User extends SentryUser
{
    use ViewableTrait;
    use TableTrait;
    use HasScopeIdTrait;

    /**
     * The users table.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The users viewer class.
     *
     * @var string
     */
    protected $viewer = 'Stevebauman\Maintenance\Viewers\UserViewer';

    /**
     * Returns the users first and last name in a concatenated string.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'].' '.$this->attributes['last_name'];
    }

    /**
     * Filters query by the inputted name.
     *
     * @param $query
     * @param null $name
     *
     * @return mixed
     */
    public function scopeName($query, $name = null)
    {
        if ($name) {
            $query->where('first_name', 'LIKE', '%'.$name.'%');
            $query->orWhere('last_name', 'LIKE', '%'.$name.'%');
        }

        return $query;
    }

    /**
     * Filters the query by the inputted username.
     *
     * @param $query
     * @param null $username
     *
     * @return mixed
     */
    public function scopeUsername($query, $username = null)
    {
        if ($username) {
            return $query->where('username', 'LIKE', '%'.$username.'%');
        }

        return $query;
    }

    /**
     * Filters the query by the inputted email.
     *
     * @param $query
     * @param null $email
     *
     * @return mixed
     */
    public function scopeEmail($query, $email = null)
    {
        if ($email) {
            return $query->where('email', 'LIKE', '%'.$email.'%');
        }

        return $query;
    }
}
