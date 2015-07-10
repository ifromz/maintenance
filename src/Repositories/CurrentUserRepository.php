<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Models\User;
use Cartalyst\Sentry\Facades\Laravel\Sentry;

class CurrentUserRepository extends Repository
{
    /**
     * @return User
     */
    public function model()
    {
        return Sentry::getUser();
    }
}
