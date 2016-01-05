<?php

namespace App\Composers;

use App\Repositories\RoleRepository;
use Illuminate\View\View;

class RoleSelectComposer
{
    /**
     * @var RoleRepository
     */
    protected $role;

    /**
     * @param RoleRepository $role
     */
    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    /**
     * @param View $view
     *
     * @return $this
     */
    public function compose(View $view)
    {
        $roles = $this->role->all()->lists('name', 'id');

        return $view->with('allRoles', $roles);
    }
}
