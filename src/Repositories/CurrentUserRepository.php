<?php

namespace Stevebauman\Maintenance\Repositories;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Stevebauman\Maintenance\Models\User;

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
