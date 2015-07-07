<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;
use Stevebauman\Maintenance\Services\UserService;

class UserSelectComposer
{
    /**
     * @var UserService
     */
    protected $user;

    /**
     * @param UserService $user
     */
    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    /**
     * @param $view
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        $users = $this->user->get()->lists('full_name', 'id');

        return $view->with('allUsers', $users);
    }
}
