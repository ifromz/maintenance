<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Admin;

use Stevebauman\Maintenance\Models\Role;
use Stevebauman\Maintenance\Repositories\RoleRepository;
use App\Http\Controllers\Controller as BaseController;

class RoleController extends BaseController
{
    /**
     * @var RoleRepository
     */
    protected $role;

    /**
     * Constructor.
     *
     * @param RoleRepository $role
     */
    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    /**
     * Returns a new grid instance of all available groups.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'name',
            'created_at',
        ];

        $settings = [
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 11,
        ];

        $transformer = function(Role $role)
        {
            return [
                'name' => $role->name,
                'created_at' => $role->created_at->format('Y-m-d g:i a'),
                'view_url' => route('maintenance.admin.roles.show', [$role->id]),
            ];
        };

        return $this->role->grid($columns, $settings, $transformer);
    }
}
