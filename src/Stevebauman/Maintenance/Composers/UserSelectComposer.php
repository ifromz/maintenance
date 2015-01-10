<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\UserService;

/**
 * Class UserSelectComposer
 * @package Stevebauman\Maintenance\Composers
 */
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
     * @return mixed
     */
    public function compose($view)
    {
        $users = $this->user->get()->lists('full_name', 'id');

        return $view->with('allUsers', $users);
    }

}
