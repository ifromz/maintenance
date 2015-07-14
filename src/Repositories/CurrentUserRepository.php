<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CurrentUserRepository extends Repository
{
    /**
     * @return User
     */
    public function model()
    {
        return Sentinel::getUser();
    }
}
