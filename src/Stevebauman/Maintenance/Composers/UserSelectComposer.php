<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\UserService;

class UserSelectComposer
{

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function compose($view)
    {
        $users = $this->user->get()->lists('full_name', 'id');

        return $view->with('allUsers', $users);
    }

}
