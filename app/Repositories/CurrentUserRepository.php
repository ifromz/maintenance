<?php

namespace App\Repositories;

use App\Models\User;

class CurrentUserRepository extends Repository
{
    /**
     * @return User
     */
    public function model()
    {
        return auth()->user();
    }
}
