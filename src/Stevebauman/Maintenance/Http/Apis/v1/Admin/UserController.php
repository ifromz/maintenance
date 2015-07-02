<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Admin;

use Stevebauman\Maintenance\Repositories\UserRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class UserController extends BaseController
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Returns a new grid instance of all users.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'first_name',
            'last_name',
            'email',
            'created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
            'throttle' => 10,
            'threshold' => 10,
        ];

        $transformer = function($user)
        {
            return [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'created_at' => $user->created_at->format('Y-m-d g:i a'),
                'view_url' => route('maintenance.admin.users.show', [$user->id]),
            ];
        };

        return $this->user->grid($columns, $settings, $transformer);
    }
}
